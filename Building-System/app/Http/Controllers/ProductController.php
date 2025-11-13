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
        $model = $this->validateType($type);
        if (!$model) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $products = $model::with('product')->get();
        return view("product.type", compact("products", "type"));
    }
    
    public function showSpec($type, $spec)
    {
        $model = $this->validateType($type);
        if (!$model) {
            return redirect()->back()->withError("This device type doesn't exist");
        }
        $specModel = $model::with('product')->findOrFail($spec);
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
            return null;
        }
        return $this->typeMap[$type];
    }

}
