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
                        <p class="title">You are about to order <strong>{{ ucwords($product->name) }}</strong></p>
                        <p class="">&#8358;{{ number_format($product->price) }}</p>
                        <div class="row justify-content-center">
                            <!-- pay with paystack -->
                            <form action="#" class="mr-1">
                              <script src="https://js.paystack.co/v1/inline.js"></script>
                              <button type="button" name="pay_now" id="pay-now" title="Pay now" onclick="payWithPaystack()" class="btn btn-primary rounded-0">Pay With Card</button>
                            </form>
                            <a href="{{ route('buy-from-wallet', ['id' => $product->id]) }}" class="btn btn-primary rounded-0" onclick="return confirm('Pay from wallet?')">Pay From Wallet</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //Stats Board -->
</div>
<script type="text/javascript">
var base_url = {!! json_encode(URL::to('/'), JSON_HEX_TAG)  !!};
var amount = {!! json_encode($product->price * 100, JSON_HEX_TAG)  !!};
var user = {!! json_encode(md5(auth()->user()->id), JSON_HEX_TAG)  !!};
var email = {!! json_encode(auth()->user()->email, JSON_HEX_TAG)  !!};
var key = {!! json_encode(env('PAYSTACK_PUBLIC'), JSON_HEX_TAG)  !!};
var productId = {!! json_encode($product->id, JSON_HEX_TAG)  !!};

  var orderObj = {
    email,
    amount,
    user,
    productId,
    key,
  };

  function payWithPaystack(){
    var handler = PaystackPop.setup({
      key: orderObj.key,
      email: orderObj.email,
      amount: orderObj.amount,
      metadata: {
        user: orderObj.user,
        productId: orderObj.productId
      },
      callback: function(response){
        // post to server to verify transaction before giving value
        window.location.href= base_url+'/card-buy/verify/'+response.reference;
        // $.get('/buy/verify/' + response.reference);
        //verifying.done(function( data ) { /* give value saved in data */ });
      },
      onClose: function(){
        alert('Click "Pay With Card" to retry payment.');
      }
    });
    handler.openIframe();
  }
</script>
@endsection
