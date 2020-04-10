@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Stats Board -->
    <div class="row justify-content-center mb-2">
        <div class="col-md-4">
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

            <div class="card">
                <div class="card-body">
                    <div>
                        <img src="{{ $product->image }}" class="img-responsive" alt="{{ $product->name }}">
                    </div>
                    <div class="card-body">
                        <p class="title">You have ordered <strong>{{ ucwords($product->name) }}</strong></p>
                        <p class="">&#8358;{{ number_format($product->price) }}</p>
                        <a href="{{ route('buy', [ 'id' => $product->id, 'slug'=>$product->slug]) }}" class="btn btn-primary rounded-0">Pay With Card</a>
                        <a href="{{ route('buy-from-wallet', ['id' => $product->id]) }}" class="btn btn-primary rounded-0" onclick="return confirm('Pay from wallet?')">Pay From Wallet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //Stats Board -->

</div>
<script type="text/javascript">
    function takeAction(){
        if(!confirm("Are you sure to buy from wallet?")){
         event.preventDefault();
        }
    }
</script>
@endsection
