@extends('layouts.app')

@section('content')
<div class="container">
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
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $products->links() }}
</div>
@endsection
