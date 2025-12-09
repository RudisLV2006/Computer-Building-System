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
    public function hasItem($type){
        return isset($this->items[$type]);
    }
    
    // Palīgu metodes, kuras sniedz palīdzību iegūt datus no sesijas
    public function getSpec($type){
        $model = $this->loadModel($type);
        return $model ?? null;
    }
    public function getField($type, $field){
        $model = $this->loadModel($type);
        return $model->{$field} ?? null;
    }
    public function getProduct($type)
    {
        $model = $this->loadModel($type);
        return $model ? $model->product : null;
    }
    public function getItems()
    {
        return $this->items;
    }

    public function addItem($type, $id){
        $this->items[$type] = [
            "product_id" => $id,
        ];
    }
    public function loadModel($type){
        if(!$this->hasItem($type)){
            return null;
        }
        $model = ProductTypeRegistry::getModel($type);
        if(!$model){
            return null;
        }
        $productId = $this->items[$type]["product_id"];
        return $model::with('product')->find($productId);
    }
}
