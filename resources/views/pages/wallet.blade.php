@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Stats Board -->
    <div class="row">

    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
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
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    @if($wallet_balance === 0)
                    <p class="display-4">&#8358;000</p>
                    @else
                    <p class="display-4">&#8358;{{ number_format($wallet_balance) }}</p>
                    @endif
                    <p class="small text-center">Wallet Balance</p>
                    <a href="{{ route('enter-funds') }}" class="btn btn-primary rounded-0">Fund Wallet</a>
                    <a href="{{ route('gift') }}" class="btn btn-primary rounded-0">Gift Funds</a>
                    <a href="{{ route('history') }}" class="btn btn-primary rounded-0">History</a>
                </div>
            </div>
        </div>
    </div>
    <!-- //Stats Board -->
</div>
@endsection
