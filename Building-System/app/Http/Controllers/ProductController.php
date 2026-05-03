<?php

namespace App\Http\Controllers;

use App\ProductTypeRegistry;
use App\CompactibilityChecker;
use App\Build;

class ProductController extends Controller
{
    public function selectCategories()
    {
        $categories = ProductTypeRegistry::all();
        return view("product.choise", compact("categories"));
    }
    public function index(string $category)
    {
        if (!ProductTypeRegistry::exists($category)) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $model = config('builder.categories')[$category];
        $query = $model::with('product');
        if (session()->has('Builder.cart')) {
            $oldCartData = session()->get('Builder.cart');
            $build = new Build($oldCartData);
            $checker = new CompactibilityChecker($build);
            $query = $checker->filter($category, $query);
        }
        $items = $query->get();
        return view("product.type", compact("category", "items"));
    }

    public function show(string $category, string $product)
    {
        if (!ProductTypeRegistry::exists($category)) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $model = config('builder.categories')[$category];
        $item = $model::with('product')->findOrFail($product);
        $view = "product.views.{$category}";
        return view($view, [
            'category' => $category,
            'item' => $item,
        ]);
    }
}
