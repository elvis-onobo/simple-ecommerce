<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Purchase;
use App\Product;
use App\Wallet;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::paginate(3);
        $wallet = Wallet::where('user_id', auth()->user()->id)->pluck('balance')->sum();
        $spent = Purchase::where('user_id', auth()->user()->id)->pluck('price')->sum();

        return view('home', compact('products', 'wallet', 'spent'));
    }
}
