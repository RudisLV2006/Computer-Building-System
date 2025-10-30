<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MotherBoardSpec;

class ProductController extends Controller
{
    public function index(){
        return view("product.choise");
    }
    public function type($type){
        $products = $this->getProducts($type);
        return view("product.type", compact("products", "type"));
    }
    public function showSpec($type, MotherBoardSpec $spec){
        $product = $spec->product;
        return view('product.view', compact('spec', 'product', 'type'));
    }


    private function getProducts($type){
        if($type=='mobo'){
            return MotherBoardSpec::with('product')->get();
        }
        return collect();
    }
}
