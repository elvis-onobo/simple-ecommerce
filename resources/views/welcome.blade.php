@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-10">
            <p class="col-md-10" style="font-size: 3em;">Welcome to SimpleCommerce</p>
            <h1 class="col-md-8" style="font-size: 2em;">By Elvis Onobo</h1>
            <p class="col-md-8">
                SimpleCommerce is a light minimalist website where you can do your
                everyday shopping for groceries, households, clothes, electronics
                and more.
            </p>
            <p class="col-md-8">
                SimpleCommerce is very easy to use. All you have to do is Register/Login
                and make a purchase directly with your Debit Card or if you prefer to have
                more speed, you can just fund your wallet and do your shopping with just
                with just one click.
            </p>
            <p class="col-md-8">
                It's a demo website so don't have your hopes too high because you will
                be shopping dummy stuff but you can totally use it to simulate your spending
                when you end up having the money. Lol!
            </p>
            <p class="col-md-8">Find the code for this project on my <a href="http://github.com/elvis-onobo/simple-ecommerce" target="_blank">Github</a></p>
            <p class="col-md-8">Feel free to mail me at elvis[dot]onobo[at]gmail[dot]com</p>

            <div class="col-md-8">
                <a href="{{ route('listing') }}" class="btn btn-primary rounded-0">Visit Shop</a>
            </div>
        </div>
    </div>


</div>
@endsection
