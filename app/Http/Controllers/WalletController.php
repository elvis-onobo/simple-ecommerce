<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(){
        return view('pages.wallet');
    }

    public function fund(){
        return view('pages.fund');
    }
}
