<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTypeRegistry;
use App\Build;
    
class BuilderController extends Controller
{
    public function index(){
        $parts = [
            'cpu','mobo','tbd'
        ];
        $cart = session()->get('Builder.cart', new Build([]));
        return view("builder", compact("parts", 'cart'));
    }

    public function addItem(Request $request, $type, $item){
        if (!ProductTypeRegistry::exists($type)) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $model = ProductTypeRegistry::getModel($type);
        $product = $model::with('product')->findOrFail($item);

        $oldCart = session()->get('Builder.cart', []);
        $cart = new Build($oldCart);
        $cart->addItem($type, $product);
        session()->put('Builder.cart', $cart);
        return redirect()->route('builder.index')->with('success', 'Component successfully added');
    }

    public function debug(){
       dd(session()->get('Builder.cart'));
    }
}
