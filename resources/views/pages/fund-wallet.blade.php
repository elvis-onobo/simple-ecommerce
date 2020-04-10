@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="">


                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif


                    <div class="card border-0 rounded-0 m-1 col-md-12">
                        <div class="card-body">
                            <form>
                                <script src="https://js.paystack.co/v1/inline.js"></script>
                                <div id="paystackEmbedContainer"></div>
                            </form>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="#"  >Terms and Conditions Apply</a>
                    </div>
                    <div>
                        <p>Card Number: 408 408 408 408 408 1</p>
                        <p>Date: Any date in the future</p>
                        <p>CVV: 408</p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script>
var base_url = {!! json_encode(URL::to('/'), JSON_HEX_TAG)  !!};
var amount = {!! json_encode(session('amount')*100, JSON_HEX_TAG)  !!};
var user = {!! json_encode(md5(auth()->user()->id), JSON_HEX_TAG)  !!};
var email = {!! json_encode(auth()->user()->email, JSON_HEX_TAG)  !!};
var key = {!! json_encode(env('PAYSTACK_PUBLIC'), JSON_HEX_TAG)  !!};

PaystackPop.setup({
    key,
    email,
    amount,
    metadata: {
        user
    },
    container: 'paystackEmbedContainer',
    callback: function(response){

    window.location.href= base_url+'/verify/'+response.reference;
    },
});
</script>

@endsection






