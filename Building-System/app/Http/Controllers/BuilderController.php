<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTypeRegistry;
use App\Build;
use App\CompactibilityChecker;
    
class BuilderController extends Controller
{
    public function index(){
        $types = [
            'cpu','mobo','tbd'
        ];
        $cart = session()->get('Builder.cart', new Build([]));
        // $checker = new CompactibilityChecker($cart);
        // $error = $checker->reviewBuild();
        return view("builder", compact("types", 'cart'));
    }

    public function addItem(Request $request, $type, $id){
        
        if (!ProductTypeRegistry::exists($type)) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $oldCart = session()->get('Builder.cart', []);
        $cart = new Build($oldCart);
        $cart->addItem($type, $id);
        session()->put('Builder.cart', $cart);
        return redirect()->route('builder.index')->with('success', 'Component successfully added');
    }

    public function debug(){
       dd(session()->get('Builder.cart'));
    }
}
