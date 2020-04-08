@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Stats Board -->
    <div class="row">

    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <p class="display-4">2,000</p>
                    <p class="small text-center">Wallet Balance</p>
                    <a href="{{ route('enter-funds') }}" class="btn btn-primary rounded-0">Fund Wallet</a>
                    <a href="" class="btn btn-primary rounded-0">Gift Funds</a>
                    <a href="" class="btn btn-primary rounded-0">History</a>
                </div>
            </div>
        </div>
    </div>
    <!-- //Stats Board -->
</div>
@endsection
