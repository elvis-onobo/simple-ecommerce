<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function buy($id){
        $product = Product::where('id', $id)->first();

        return view('pages.buy', compact('products'));
    }
}
