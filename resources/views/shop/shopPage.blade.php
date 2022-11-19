@extends('layouts/app')
@section('title')
    Shop
@endsection
@extends('layouts/header')
@section('content')
    <div class="container mt-5 mx-auto relative min-h-screen text-center">
        <h2 class="mb-5 fs-1 text-center">Shop assortment</h2>
        <div class="row">
            @foreach ($collections as $item)
                <div class="card col-lg-3 offset-lg-1 col-md-5 offset-md-1 col-10 offset-1 mb-5 p-2 position-relative">
                    <img src="shopItems/{!! $item['itemImage'] !!}" class="card-img-top p-2" alt="{!! $item['itemImage'] !!}">
                    <div class="card-body text-left lead">
                        <h5 class="card-title mb-3">{!! $item['itemName'] !!}</h5>
                        <p class="card-text mb-2">Manufacturer: {!! $item['manufacturer'] !!}</p>
                        <p class="card-text mb-5">Year: {!! $item['created_year'] !!}</p>
                        <a href="/product-services/{{$item['id']}}" class="lead btn btn-outline-primary col-12 position-absolute bottom-0 start-0 rounded-0 rounded-bottom">Add for: {!! $item['itemCost'] !!} BYN</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
