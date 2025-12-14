<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTypeRegistry;
use App\CompactibilityChecker;
use App\Build;

class ProductController extends Controller
{
    public function index()
    {
        $types = ProductTypeRegistry::returnTypes();
        return view("product.choise", compact("types"));
    }
    public function listByType($type)
    {
        if (!ProductTypeRegistry::exists($type)) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $model = ProductTypeRegistry::getModel($type);
        $query = $model::with('product');
        if (session()->has('Builder.cart')) {
            $build = new Build(session()->get('Builder.cart'));
            $checker = new CompactibilityChecker($build);
            $query = $checker->getCompactibleProduct($type, $query);
        }
        $items = $query->get();
        return view("product.type", compact("items", "type"));
    }

    public function showSpec($type, $id)
    {
        if (!ProductTypeRegistry::exists($type)) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $model = ProductTypeRegistry::getModel($type);
        $itemModel = $model::with('product')->findOrFail($id);
        $product = $itemModel->product;
        $view = "product.views.{$type}";
        return view($view, [
            'item' => $itemModel,
            'product' => $product,
            'type' => $type
        ]);
    }
}
