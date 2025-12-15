<?php

namespace App;

use App\ProductTypeRegistry;


// Tiek pielietota, lai saglabātu objektu Laravel sesija.
class Build
{
    public $items = null;

    public function __construct($oldcart)
    {
        $this->items = $oldcart->items ?? [];
    }
    public function hasItem($type)
    {
        if ($type === 'ram') {
            return !empty($this->items['ram'] ?? []);
        }
        return isset($this->items[$type]);
    }

    // Palīgu metodes, kuras sniedz palīdzību iegūt datus no sesijas
    public function getSpec($type)
    {
        $model = $this->loadModel($type);
        return $model ?? null;
    }
    public function getField($type, $field)
    {
        $model = $this->loadModel($type);
        if (in_array($type, ['ram'])) {
            \Log::debug($model);
            return $model[0]->{$field} ?? null;
        }

        return $model->{$field} ?? null;
    }
    public function getProduct($type)
    {
        $model = $this->loadModel($type);
        if (in_array($type, ['ram'])) {
            return $model->map(fn($item) => $item->product);
        }
        return $model ? $model->product : null;
    }
    public function getItems()
    {
        return $this->items;
    }

    public function addItem($type, $id)
    {
        if ($type === 'ram') {
            if (!isset($this->items['ram'][$id])) {
                $this->items['ram'][$id] = 0;
            }

            $this->items['ram'][$id]++;
            return;
        }
        $this->items[$type] = [
            "product_id" => $id,
        ];
    }
    public function loadModel($type)
    {
        if (!$this->hasItem($type)) {
            return null;
        }
        $model = ProductTypeRegistry::getModel($type);
        if ($this->isQuantifiableType($type)) {
            return $this->loadMultipleInstances($type, $model);
        }
        $productId = $this->items[$type]["product_id"];
        return $model::with('product')->find($productId);
    }
    protected function isQuantifiableType($type)
    {
        // Consider moving to config: config('cart.quantifiable_types')
        return in_array($type, ['ram']);
    }
    protected function loadMultipleInstances($type, $model)
    {
        $items = $this->items[$type];

        $models = $model::with('product')
            ->whereIn('product_id', array_keys($items))
            ->get()
            ->keyBy('product_id');

        \Log::debug('Loaded base models', ['type' => $type, 'count' => $models->count()]);

        $instances = collect();

        foreach ($items as $productId => $quantity) {
            if (!isset($models[$productId])) {
                \Log::warning("Product not found", ['type' => $type, 'product_id' => $productId]);
                continue;
            }

            // Add original + clones
            $instances->push($models[$productId]);

            for ($i = 1; $i < $quantity; $i++) {
                $instances->push(clone $models[$productId]);
            }
        }

        \Log::debug('Generated instances', ['type' => $type, 'total' => $instances->count()]);

        return $instances;
    }
}
