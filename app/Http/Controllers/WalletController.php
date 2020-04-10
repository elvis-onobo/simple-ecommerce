<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Wallet;
use App\User;

class WalletController extends Controller
{
    /*
    * REUSABLE METHODS
    */
    // deducts amount after transfer/gifting
    private function deduct($user, $amount, $nature){
        if( Wallet::create([
            'user_id' => $user,
            'balance' => -$amount,
            'reference' => 'Nil',
            'authorization' => 'Nil',
            'nature_of_tranx' => 'Gift to '. $nature
        ]) ){
        return back()->with('status', 'You have successfully gifted '.$amount.' naira to '.$nature);
        };
    }

    // get user's wallet balance
    private function balance(){
        return Wallet::where('user_id', auth()->user()->id)->pluck('balance')->sum();
    }

    // check if user exists
    private function userExists($email){
        if (User::where('email', $email)->exists()) {
            return User::where('email', $email)->first();
        } else {
            return back()->with('error', "This user doesn't exist");
        }
    }
    /*
    * END REUSABLE METHODS
    */

    // show wallet page
    public function index(){
        // return the wallet balance
        $wallet_balance = $this->balance();

        return view('pages.wallet', compact('wallet_balance'));
    }

    // fund wallet form
    public function enter_fund(){
        return view('pages.fund');
    }

    // fund wallet route
    public function fund_wallet(Request $request){
        session(['amount'=>$request->amount]);

        return view('pages.fund-wallet');
    }

    // show the gifting form
    public function gift(){
        return view('pages.gift');
    }

    // transfer the money to the recipient
    public function gift_fund(Request $request){
        // check if user exits
        if ($this->userExists($request->email)) {
            $user = $this->userExists($request->email);
            // check if the user has sufficient balance to transfer
            if($this->balance() >= $request->amount && $request->amount > 0){
                if( Wallet::create([
                    'user_id' => $user->id,
                    'balance' => $request->amount,
                    'reference' => 'Nil',
                    'authorization' => 'Nil',
                    'nature_of_tranx' => 'Tranfer from '. auth()->user()->name
                ])){
                    // if transfer successful, deduct from the sender
                    return $this->deduct(auth()->user()->id, $request->amount, $user->name);
                }else{
                    return back()->with('error', 'Transfer Failed!');
                }
            } else {
                return back()->with('error', "Transfer failed, Insufficient funds");
            }
        }
    }

    // verifies the transaction
    public function verify($reference){
        $secret_key = env('PAYSTACK_SECRET');
        $uri ='https://api.paystack.co/transaction/verify/'.$reference;

        $response = Http::withToken($secret_key)->get($uri);
        return $response;
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

    // get a user's wallet history
    public function history(){
        $history = Wallet::where('user_id', auth()->user()->id)->simplePaginate(20);

        return view('pages.wallet-history', compact('history'));
    }
}
