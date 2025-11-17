<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuilderController extends Controller
{
    public function index(){
        $parts = [
            'cpu','mobo','tbd'
        ];
        return view("builder", compact("parts"));
    }
}
