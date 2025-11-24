<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTypeRegistry;

class ProductController extends Controller
{
    public function index(){
        return view("product.choise");
    }
    public function listByType($type)
    {
        if (!ProductTypeRegistry::exists($type)) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $model = ProductTypeRegistry::getModel($type);
        $items = $model::with('product')->get();
        return view("product.type", compact("items", "type"));
    }
    
    public function showSpec($type, $item)
    {
        if (!ProductTypeRegistry::exists($type)) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $model = ProductTypeRegistry::getModel($type);
        $itemModel = $model::with('product')->findOrFail($item);
        $product = $itemModel->product;    
        $view = "product.views.{$type}";    
        return view($view, [
            'item' => $itemModel,
            'product' => $product,
            'type' => $type
        ]);
    } 
}
