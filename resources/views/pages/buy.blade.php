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
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div>
                        <img src="{{ $product->image }}" class="img-responsive" alt="{{ $product->name }}">
                    </div>
                    <p class="title">{{ $product->name }}</p>
                    <p class="">{{ $product->price }}</p>
                    <a href="{{ route('buy', [ 'id' => $product->id, 'slug'=>$product->slug]) }}" class="btn btn-primary rounded-0">Buy</a>
                </div>
            </div>
        </div>
    </div>
    <!-- //Stats Board -->

</div>
@endsection
