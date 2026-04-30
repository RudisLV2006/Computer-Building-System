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
    public function getProduct($type)
    {
        $model = $this->loadModel($type);
        return $model?->product;
    }
    public function getField($type, $field)
    {
        $model = $this->loadModel($type);
        return $model->{$field} ?? null;
    }
    public function initCache()
    {
        foreach ($this->items as $type => $products) {
            foreach ($products as $id => $data) {
                $this->loadModel($type, $id);
            }
        }
    }
    public function addItem($type, $id)
    {
        if (!isset($this->items[$type][$id])) {
            $this->items[$type][$id] = [
                "product_id" => $id,
                "count" => 0
            ];
        }

        if (in_array($type, ["ram"])) {
            $this->items[$type][$id]['count']++;
        } else {
            // Pārraksta — tikai viens var būt
            $this->items[$type] = [
                $id => ["product_id" => $id, "count" => 1]
            ];
        }
    }

    public function loadModel($type, $id = null)
    {
        $id = $id ?? array_key_first($this->items[$type]);
        if (isset($this->modelCache[$type][$id])) {
            return $this->modelCache[$type][$id];
        }

        if (!ProductTypeRegistry::exists($type) || !isset($this->items[$type])) {
            return null;
        }
        $model = ProductTypeRegistry::getModel($type);
        $productId = $this->items[$type][$id]["product_id"];
        return $this->modelCache[$type][$id] = $model::with('product')->find($productId);
    }

    public function hasItem($type)
    {
        return isset($this->items[$type]);
    }
    public function debugCache()
    {
        print_r($this->modelCache);
    }
}
