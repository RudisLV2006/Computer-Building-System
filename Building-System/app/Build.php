<?php

namespace App;

class Build
{
    /**
     * Create a new class instance.
     */

    public $item;

    public function __construct($oldBuilt)
    {
        $this->item = $oldBuilt;
    }

    public static function printItem(){
        dd($this->item);
    }
}
