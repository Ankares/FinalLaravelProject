@extends('layouts/app')
@section('title')
    Services
@endsection
@extends('layouts/header')
@section('content')
        <div class="container">
            <p class="mt-5 mb-4 text-center display-6">Services for: {!! $item['itemName'] !!}</p>
            <div class="list-group-item bg-white border shadow-sm offset-md-1 offset-0 col-md-10 col-12 mb-4 mt-3 fs-5 px-4 py-2">
                <form action="/shopping-cart" method="POST"> 
                @csrf
                    @if (isset($item['warrantyPeriod']))
                        <p class="fs-3 mt-3">Warranty</p>
                        <div class="mx-4 my-3">
                            <p class="mb-2">Period of warranty: {!! $item['warrantyPeriod'] !!}</p>
                            <p class="mb-2">Warranty Cost: {!! $item['warrantyCost'] !!} BYN</p> 
                            <input type="checkbox" name="warranty" class="form-check-input"> Include warranty</input>
                        </div>
                        <hr> 
                    @endif
                    @if (isset($item['deliveryPeriod']))
                        <p class="fs-3 mt-3">Delivery</p>
                        <div class="mx-4 my-3">
                            <p class="mb-2">Period of delivery: {!! $item['deliveryPeriod'] !!}</p>
                            <p class="mb-2">Delivery Cost: {!! $item['deliveryCost'] !!} BYN</p> 
                            <input type="checkbox" name="delivery" class="form-check-input"> Include delivery</input>
                        </div>
                        <hr> 
                    @endif
                    @if (isset($item['itemSetupCost']))
                        <p class="fs-3 mt-3">Set up</p>
                        <div class="mx-4 my-3">
                            <p class="mb-2">Set up Cost: {!! $item['itemSetupCost'] !!} BYN</p> 
                            <input type="checkbox" name="setUp" class="form-check-input"> Include set up</input>
                        </div>
                        <hr>
                    @endif
                    
                    <input type="hidden" name="itemId" value="{!! $item['id'] !!}"></input>
                    <button type="submit" class="btn btn-outline-primary mt-5 p-2 col-md-4 col-8">Add to cart</button>
                </form>
            </div>
        </div>  
@endsection
    
   


