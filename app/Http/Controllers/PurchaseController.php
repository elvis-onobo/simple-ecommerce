<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Purchase;

class PurchaseController extends Controller
{
        // verifies the transaction
    public function verify($reference){
        $secret_key = env('PAYSTACK_SECRET');
        $uri ='https://api.paystack.co/transaction/verify/'.$reference;

        $response = Http::withToken($secret_key)->get($uri);

        // check if data returned a success case then save ro DB
        if($response['data']['status'] === 'success'){
            // check if the user is the same user that made the payment
            if (md5(auth()->user()->id) === $response['data']['metadata']['user']) {
                $purchase = new Purchase;
                $purchase->user_id = auth()->user()->id;
                $purchase->product_id = $response['data']['metadata']['productId'];
                // divide amount by 100 to store actual value
                $purchase->price = $response['data']['amount']/100;
                $purchase->reference = $response['data']['reference'];
                $purchase->authorization = $response['data']['authorization']['authorization_code'];
                if($purchase->save()){
                        return redirect('home')->with('status', 'Payment Successful');
                }
            }
            return back()->with('error', 'Wrong user, please report this to admin!');
        }
        return back()->with('error', 'This transaction could not be verified!');
    }

    // get a user's spenting history
    public function history(){
        $purchase = Purchase::where('user_id', auth()->user()->id)
                    ->join('products', 'purchases.product_id', '=', 'products.id' )
                    ->select('products.name', 'purchases.price', 'purchases.created_at' )
                    ->simplePaginate(20);

        return view('pages.purchase-history', compact('purchase'));
    }
}
