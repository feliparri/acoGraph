<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        $products = \App\Products::all();
        dd(['products' => $products]);
    }
}
