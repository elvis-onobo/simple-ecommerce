<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Wallet;

class WalletController extends Controller
{
    public function index(){
        // return the wallet balance
        $wallet_balance = Wallet::where('user_id', auth()->user()->id)
                            ->pluck('balance')
                            ->sum();

        return view('pages.wallet', compact('wallet_balance'));
    }

    public function enter_fund(){
        return view('pages.fund');
    }

    public function fund_wallet(Request $request){
        session(['amount'=>$request->amount]);

        return view('pages.fund-wallet');
    }

    public function verify($reference){
        $secret_key = env('PAYSTACK_SECRET');

        $uri ='https://api.paystack.co/transaction/verify/'.$reference;

        $response = Http::withToken($secret_key)->get($uri);

        // check if data returned a success case then save ro DB
        if($response['data']['status'] === 'success'){
            // check if the user is the same user that made the payment
            if (md5(auth()->user()->id) === $response['data']['metadata']['user']) {
                $wallet = new Wallet;
                $wallet->user_id = auth()->user()->id;
                // divide amount by 100 to store actual value
                $wallet->balance = $response['data']['amount']/100;
                $wallet->reference = $response['data']['reference'];
                $wallet->authorization = $response['data']['authorization']['authorization_code'];
                $wallet->nature_of_tranx = 'Deposit';

                if($wallet->save()){
                        return redirect()->route('wallet')->with('status', 'Successful');
                }
            }
            return back()->with('error', 'Wrong user, please report this to admin!');
        }
        return back()->with('error', 'This transaction could not be verified!');
    }
}
