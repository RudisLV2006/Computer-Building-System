<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MotherBoardSpec;

class ProductController extends Controller
{
    private array $typeMap = [
        'mobo' => MotherBoardSpec::class,
    ];
    public function index(){
        return view("product.choise");
    }
    public function listByType($type){
        $products = $this->getProducts($type);
        return view("product.type", compact("products", "type"));
    }
    public function showSpec($type, MotherBoardSpec $spec){
        $product = $spec->product;
        return view('product.view', compact('spec', 'product', 'type'));
    }

    private function getProducts($type){
        if(!isset($this->typeMap[$type]))
            return collect();
        $model = $this->typeMap[$type]::with('product')->get();
        return $model;
    }
}
