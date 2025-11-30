<?php

namespace App;

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
        return $this->items[$type]['spec'];
    }
    public function getField($type, $field){
        return $this->items[$type]['spec'][$field];
    }
    public function getProduct($type)
    {
        return $this->items[$type]['spec']['product'];
    }
    public function getItems()
    {
        return $this->items;
    }


    public function addItem($type, $product){
        $this->items[$type] = [
            "id" => $product->product_id,
            'spec' => $product->toArray(),
        ];
    }
}
