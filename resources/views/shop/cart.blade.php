@extends('layouts/app')
@section('title')
    Cart
@endsection
@extends('layouts/header')
@section('content')
    <div class="container">
        @if ($products)
            <p class="mt-5 mb-4 text-center fs-1">Shopping cart</p>
            <div class="list-group-item bg-white border shadow-sm col-10 offset-1 mb-4 mt-3 fs-5 p-4">
                @foreach ($products as $product)
                    <p class="lead fs-4 mt-3 mb-2 fw-bold">{!! $product['itemName'] !!}</p>
                    <div class="mx-4 mb-4">
                        <img src="shopItems/{!! $product['itemImage'] !!}" class="img-fluid w-25 mb-2 mt-1" alt="{!! $product['itemImage'] !!}">

                        @if (isset($product['warrantyPeriod']))
                            <p class="mt-2 fw-bold">Warranty:</p> 
                            <p class="mt-2">{!! $product['warrantyPeriod'] !!}, cost: {!! $product['warrantyCost'] !!} BYN</p>   
                        @endif

                        @if (isset($product['deliveryPeriod']))
                            <p class="mt-2 fw-bold">Delivery:</p> 
                            <p class="mt-2">{!! date('Y-m-d', strtotime($product['deliveryPeriod'])) !!}, cost: {!! $product['deliveryCost'] !!} BYN</p>  
                        @endif

                        @if (isset($product['setupCost']))
                            <p class="mt-2 fw-bold">Set up:</p>  
                            <p class="mt-2">Cost: {!! $product['setupCost'] !!} BYN</p>  
                        @endif

                        <p class="mt-4">
                            @if (isset($product['totalPrice']))
                                <p class="mt-2 fs-4">
                                    Total Price: {!! $product['totalPrice'] !!} BYN
                                </p>  
                            @endif
                        </p>
                    </div> 
                    <hr>
                @endforeach        
            </div>  
        @else
            <p class="mt-5 mb-4 text-center fs-5">There is no items in your cart</p>
        @endif
    </div>

@endsection