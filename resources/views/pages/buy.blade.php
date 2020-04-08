@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Stats Board -->
    <div class="row justify-content-center mb-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <p class="">You are about to buy <strong>Product 1</strong>
                    for N15,000</p>
                    <a href="" class="btn btn-primary">Pay With Wallet</a>
                    <a href="" class="btn btn-primary">Pay With Card</a>
                </div>
            </div>
        </div>
    </div>
    <!-- //Stats Board -->

</div>
@endsection
