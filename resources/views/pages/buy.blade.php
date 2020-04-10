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
var amount = {!! json_encode($product->price * 100, JSON_HEX_TAG)  !!};
var user = {!! json_encode(md5(auth()->user()->id), JSON_HEX_TAG)  !!};
var email = {!! json_encode(auth()->user()->email, JSON_HEX_TAG)  !!};
var key = {!! json_encode(env('PAYSTACK_PUBLIC'), JSON_HEX_TAG)  !!};
var productId = {!! json_encode($product->id, JSON_HEX_TAG)  !!};

  var orderObj = {
    email,
    amount,
    userId: user,
    productId,
    key,
  };

  // function saveOrderThenPayWithPaystack(){
  //   // Send the data to save using post
  //   var posting = $.post( '/save-order', orderObj );

  //   posting.done(function( data ) {
  //     /* check result from the attempt */
  //     payWithPaystack(data);
  //   });
  //   posting.fail(function( data ) { /* and if it failed... */ });
  // }

  function payWithPaystack(){
    var handler = PaystackPop.setup({
      // This assumes you already created a constant named
      // PAYSTACK_PUBLIC_KEY with your public key from the
      // Paystack dashboard. You can as well just paste it
      // instead of creating the constant
      key: orderObj.key,
      email: orderObj.email,
      amount: orderObj.amount,
      metadata: {
        userId: orderObj.userId,
        productId: orderObj.productId,
        // custom_fields: [
        //   {
        //     display_name: "Paid on",
        //     variable_name: "paid_on",
        //     value: 'Website'
        //   },
        //   {
        //     display_name: "Paid via",
        //     variable_name: "paid_via",
        //     value: 'Inline Popup'
        //   }
        // ]
      },
      callback: function(response){
        // post to server to verify transaction before giving value
        var verifying = $.get('/buy/verify/' + response.reference);
        verifying.done(function( data ) { /* give value saved in data */ });
      },
      onClose: function(){
        alert('Click "Pay With Card" to retry payment.');
      }
    });
    handler.openIframe();
  }
</script>
@endsection
