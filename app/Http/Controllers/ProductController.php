<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Purchase;
use App\Product;
use App\Wallet;

class ProductController extends Controller
{
    /*
    * REUSABLE METHODS
    */
    // deducts amount after transfer/gifting
    private function deduct($user, $amount, $nature){
        return Wallet::create([
            'user_id' => $user,
            'balance' => -$amount,
            'reference' => 'Nil',
            'authorization' => 'Nil',
            'nature_of_tranx' => 'Purchased '. $nature
        ]);
        // return back()->with('status', 'You have successfully purchased '.$nature.' at '.$amount.' naira');
    }

    // gets the wallet balance
    private function balance(){
        return Wallet::where('user_id', auth()->user()->id)->pluck('balance')->sum();
    }
    /*
    * END REUSABLE METHODS
    */

    // return a list of the products
    public function listing(){
        $products = Product::paginate(3);

        return view('pages.listing', compact('products'));
    }

    public function buy($id){
        $product = Product::where('id', $id)->first();

        return view('pages.buy', compact('product'));
    }

    public function buy_from_wallet($id){
        $product = Product::where('id', $id)->first();
        // check if sufficiend funds in wallet to buy
        if ($this->balance() >= $product->price) {
            // deduct the product->price from user wallet
            if ($this->deduct(auth()->user()->id, $product->price, $product->name)) {
                if(Purchase::create([
                    'user_id'=>auth()->user()->id,
                    'product_id'=> $id,
                    'price'=> $product->price,
                    'reference'=> 'nil',
                    'authorization'=> 'nil'
                ])){
                return back()->with('status', 'You have successfully purchased '.$product->name.' at '.$product->price.' naira');
                };
            }
        } else {
            return back()->with('error', "Transaction failed, Insufficient funds!");
        }
    }

}
