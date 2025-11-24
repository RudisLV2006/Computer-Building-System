<?php

namespace App;

class Build
{
    public $item = [];

    public function __construct($oldcart)
    {
        $this->item = $oldcart ?? [];
    }

    public function printItem(){
        return $this->item;
    }

    public function addItem($type, $product){
        $this->item[$type] = [
            "id" => $product->product_id,
            'product' => $product->toArray(),
        ];
    }
}
