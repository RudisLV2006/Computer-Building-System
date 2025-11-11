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
    public function listByType($type){
        $products = $this->getProducts($type);
        return view("product.type", compact("products", "type"));
    }
    public function showSpec($type, $spec){
        $specModel = null;
        $view = null;
        switch ($type){
            case 'mobo':
                $specModel = MotherBoardSpec::with('product')->findOrFail($spec);
                $view = 'product.views.mobo';
                break;
                
            case 'cpu':
               $specModel = CPUSpec::with('product')->findOrFail($spec);
               $view = 'product.views.cpu';
               break;
            default:
                abort(404);
        }
        $product = $specModel->product;
        return view($view, [
            'spec' => $specModel,
            'product' => $product,
            'type' => $type
        ]);
    }

    private function getProducts($type){
        if(!isset($this->typeMap[$type]))
            return collect();
        return $this->typeMap[$type]::with('product')->get();
    }
}
