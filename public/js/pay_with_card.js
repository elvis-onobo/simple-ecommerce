<script>
var amount = {!! json_encode(session('amount')*100, JSON_HEX_TAG)  !!};
var user = {!! json_encode(auth()->user()->id, JSON_HEX_TAG)  !!};
var email = {!! json_encode(auth()->user()->email, JSON_HEX_TAG)  !!};
var key = {!! json_encode(env('PAYSTACK_PUBLIC'), JSON_HEX_TAG)  !!};

PaystackPop.setup({
    key,
    email,
    amount,
    metadata: {
        user,
        amount
    },

    container: 'paystackEmbedContainer',
    callback: function(response){

    window.location.href= '/youvest/public/verify/'+response.reference;
    },
});
</script>