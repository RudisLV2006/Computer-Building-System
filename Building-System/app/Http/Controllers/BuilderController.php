<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTypeRegistry;
use App\Build;
use App\CompactibilityChecker;

class BuilderController extends Controller
{
    public function index()
    {
        $categories = ProductTypeRegistry::all();
        $cart = session()->get('Builder.cart', new Build());
        $service = new CompactibilityChecker($cart);

        $errors = $service->validate();
        $products = $cart->loadProducts();
        return view("builder.builder", compact("categories", 'products', 'errors'));
    }

    public function store(string $category, string $id)
    {

        if (!ProductTypeRegistry::exists($category)) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $oldCartData = session()->get('Builder.cart');
        $cart = new Build($oldCartData);
        $cart->addItem($category, $id);
        session()->put('Builder.cart', $cart);
        return redirect()->route('builder.index')->with('success', 'Component successfully added');
    }
    public function remove(string $category, string $id)
    {
        $oldCartData = session()->get('Builder.cart');
        $cart = new Build($oldCartData);
        $cart->removeItem($category, $id);
        session()->put('Builder.cart', $cart);
        return redirect()->route('builder.index')->with('success', 'Component successfully removed');
    }


    public function debug()
    {
        dd(session()->get('Builder.cart'));
    }
}
