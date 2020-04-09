@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">

                @if(count($history) > 0)
                <div class="row table-responsive scroll">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Balance (&#8358;)</th>
                                <th>Nature of Transaction</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $his)
                            <tr>
                                <th>{{ number_format($his->balance) }}</th>
                                <th>{{ $his->nature_of_tranx }}</th>
                                <th>{{ date('D, j F, Y', strtotime($his->created_at)) }}</th>
                                <th>{{ date('h:m A', strtotime($his->created_at)) }}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                {{ $history->links() }}
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
