<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CPUSpec;
    
class BuilderController extends Controller
{
    public function index(){
        $parts = [
            'cpu','mobo','tbd'
        ];
        return view("builder", compact("parts"));
    }

    public function addItem(Request $request, $type, $item){
        $product = CPUSpec::with('product')->findOrFail($item);
        dd($product);
    }
}
