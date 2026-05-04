<?php

namespace App;

use App\Models\Product;
use App\ProductTypeRegistry;


// Tiek pielietota, lai saglabātu objektu Laravel sesija.
class Build
{
    public array $items = [];
    private array $modelCache = [];

    public function __sleep()
    {
        // Mēs atgriežam tikai tos mainīgos, kas reāli veido grozu.
        // 'modelCache' šeit NAV iekļauts, tāpēc tas sesijā netiks saglabāts vispār!
        return ["items"];
    }
    public function __construct(?self $oldcart = null)
    {
        $this->items = $oldcart?->items ?? [];
    }
    public function loadModel(string $category)
    {
        if (!isset($this->items[$category])) return;

        $id = array_key_first($this->items[$category]);

        if (isset($this->modelCache[$category][$id]))
            return $this->modelCache[$category][$id];

        $model = config('builder.categories')[$category];
        $productId = $this->items[$category][$id]['product_id'];

        return $this->modelCache[$category][$id] = $model::find($productId);
    }
    public function getField(string $category, string $field)
    {
        $model = $this->loadModel($category);

        if ($model->{$field} !== null) {
            return $model->{$field};
        }

        if ($model->relationLoaded($field . 's') || method_exists($model, $field . 's')) {
            return $model->{$field . 's'}->pluck($field)->toArray();
        }
        return null;
    }
    public function addItem(string $category, string $id)
    {
        if (!isset($this->items[$category][$id])) {
            $this->items[$category][$id] = [
                "product_id" => $id,
                "count" => 0
            ];
        }

        if (ProductTypeRegistry::isMultiple($category)) {
            $this->items[$category][$id]['count']++;
        } else {
            // Pārraksta — tikai viens var būt
            $this->items[$category] = [
                $id => ["product_id" => $id, "count" => 1]
            ];
        }
    }
    public function removeItem(string $category, string $id)
    {
        if (!isset($this->items[$category]))
            return;
        $this->items[$category][$id]['count']--;
        if ($this->items[$category][$id]['count'] <= 0) {
            unset($this->items[$category][$id]);
        }
        if (empty($this->items[$category])) {
            unset($this->items[$category]);
        }
    }
    public function hasItem(string $category)
    {
        return isset($this->items[$category]);
    }
    public function loadProducts()
    {
        /*
        "cpu" => array:1 [▼
            11 => array:2 [▶]
        ]   flatten(1) -> no'nema pirmo masīvu jeb "cpu" => array:1 [▼
        */
        $items = collect($this->items)->flatten(1);

        $productIds = $items->pluck('product_id')->unique()->values();

        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $expanded = $items->map(function ($item) use ($products) {
            $product = $products->get($item['product_id']);
            return $product ? ['product' => $product, 'count' => $item['count']] : null;
        })->filter();

        return $expanded->groupBy(fn($item) => $item['product']->type);
    }

    public function getItems()
    {
        return $this->items;
    }
}
