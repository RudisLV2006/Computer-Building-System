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
    public function getProduct($category, $id = null)
    {
        $model = $this->loadModel($category, $id);
        return $model?->product;
    }
    public function getField($category, $field)
    {
        $model = $this->loadModel($category);
        if ($model->{$field} !== null) {
            return $model->{$field};
        }

        // fallback: try loading from related table
        // e.g. cooler -> sockets
        if ($model->relationLoaded($field . 's') || method_exists($model, $field . 's')) {
            return $model->{$field . 's'}->pluck($field)->toArray();
        }
        return null;
    }
    public function addItem($category, $id)
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

    public function loadModel($category, $id = null)
    {
        $id = $id ?? array_key_first($this->items[$category]);
        if (isset($this->modelCache[$category][$id])) {
            return $this->modelCache[$category][$id];
        }

        if (!ProductTypeRegistry::exists($category) || !isset($this->items[$category])) {
            return null;
        }
        $model = config('builder.categories')[$category];
        $productId = $this->items[$category][$id]["product_id"];
        return $this->modelCache[$category][$id] = $model::with('product')->find($productId);
    }

    public function hasItem($category)
    {
        return isset($this->items[$category]);
    }
    public function debugCache()
    {
        print_r($this->modelCache);
    }

    public function loadProducts()
    {
        $items = collect($this->items)->flatten(1);

        $productIds = $items->pluck('product_id')->unique()->values();

        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Expand by count so the view can just foreach
        $expanded = $items->flatMap(function ($item) use ($products) {
            $product = $products->get($item['product_id']);
            return $product ? array_fill(0, $item['count'], $product) : [];
        });

        return $expanded->groupBy('type');
    }
}
