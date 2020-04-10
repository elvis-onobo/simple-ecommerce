@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">

                @if(count($purchase) > 0)
                <div class="row table-responsive scroll">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Balance (&#8358;)</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchase as $pur)
                            <tr>
                                <th>{{ number_format($pur->price) }}</th>
                                <th>{{ $pur->name }}</th>
                                <th>{{ date('D, j F, Y', strtotime($pur->created_at)) }}</th>
                                <th>{{ date('h:m A', strtotime($pur->created_at)) }}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                {{ $purchase->links() }}
                </div>
                @else
                <div class="row justify-content-center">
                    <div class="col-md-4 text-center">
                        <h3>Its so lonely in here...</h3>
                        <img class="card-img-top" src="{{ asset('img/download.jfif') }}" alt="img" />
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
