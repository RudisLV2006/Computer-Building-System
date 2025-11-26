<?php

namespace App;

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
    public function getSpec($type){
        return $this->item[$type]['spec'];
    }
    public function getField($type, $field){
        return $this->item[$type]['spec'][$field];
    }
    public function getProduct($type)
    {
        return $this->items[$type]['spec']['product'];
    }

    public function addItem($type, $product){
        $this->items[$type] = [
            "id" => $product->product_id,
            'spec' => $product->toArray(),
        ];
    }
}
