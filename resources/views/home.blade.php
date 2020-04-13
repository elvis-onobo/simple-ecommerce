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

    <!-- Stats Board -->
    <div class="row justify-content-center mb-2">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    @if($wallet > 0 )
                    <p class="display-4 text-center">&#8358;{{ number_format($wallet) }}</p>
                    @else
                    <p class="display-4 text-center">Nothing</p>
                    @endif
                    <p class="small text-center">Wallet Balance</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    @if($spent > 0 )
                    <p class="display-4 text-center">&#8358;{{ number_format($spent) }}</p>
                    @else
                    <p class="display-4 text-center">Chai!</p>
                    @endif
                    <p class="small text-center">Total Spent</p>
                </div>
            </div>
        </div>
    </div>
    <!-- //Stats Board -->

    <div class="row justify-content-center">
        @foreach($products as $product)
        <div class="col-md-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div>
                        <img src="{{ $product->image }}" class="img-responsive" alt="{{ $product->name }}">
                    </div>
                    <div class="card-body">
                        <p class="title">{{ ucwords($product->name) }}</p>
                        <p class="">&#8358;{{ number_format($product->price) }}</p>
                        <a href="{{ route('buy', [ 'id' => $product->id, 'slug'=>$product->slug]) }}" class="btn btn-primary rounded-0">Buy</a>
                        <a href="" class="btn btn-warning rounded-0">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{ $products->links() }}

    </div>
</div>
@endsection
