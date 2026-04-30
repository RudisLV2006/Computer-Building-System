<?php

namespace App;

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
    public function getProduct($category)
    {
        $model = $this->loadModel($category);
        return $model?->product;
    }
    public function getField($category, $field)
    {
        $model = $this->loadModel($category);
        return $model->{$field} ?? null;
    }
    public function initCache()
    {
        foreach ($this->items as $category => $products) {
            foreach ($products as $id => $data) {
                $this->loadModel($category, $id);
            }
        }
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
}
