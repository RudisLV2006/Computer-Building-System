<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MotherBoardSpec;
use App\Models\CPUSpec;

class ProductController extends Controller
{
    private array $typeMap = [
        'mobo' => MotherBoardSpec::class,
        'cpu' => CPUSpec::class,
    ];
    public function index(){
        return view("product.choise");
    }
    public function listByType($type)
    {
        $this->validateType($type);
    
        $products = $this->typeMap[$type]::with('product')->get();
    
        if ($products->isEmpty()) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
    
        return view("product.type", compact("products", "type"));
    }
    
    public function showSpec($type, $spec)
    {
        $this->validateType($type);
    
        $specModel = $this->typeMap[$type]::with('product')->findOrFail($spec);
        $product = $specModel->product;
    
        $view = "product.views.{$type}";
    
        return view($view, [
            'spec' => $specModel,
            'product' => $product,
            'type' => $type
        ]);
    }


    private function validateType($type)
    {
        if (!isset($this->typeMap[$type])) {
            abort(404);
        }
    }

}
