@extends('layouts/app')
@section('title')
    Edit product
@endsection
@extends('layouts/header')
@section('content')
    <div class="container col-md-6 col-12">
        <p class="text-center display-6 mt-5">Edit {!! $item['itemName'] !!}</p>
        <form action={{ route('update', ['id' => $item['id']]) }} method="post" enctype="multipart/form-data" class="form-control border shadow-sm mt-4 py-3 px-5 mx-auto justify-content-center">  
            @csrf
            <p class="text-center fs-2 mt-1">Product</p>
            <input type="hidden" name="id" value={!! $item['id'] !!}>
            <div class="form-group fs-4">
                <label class="mb-2">Item name:</label>
                <input type="text" name="itemName" class="form-control mb-2" placeholder="Enter item name" value={!! $item['itemName'] !!}>
                @error('itemName')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Manufacturer:</label>
                <input type="text" name="manufacturer" class="form-control mb-2" placeholder="Enter manufacturer" value={!! $item['manufacturer'] !!}>  
                @error('manufacturer')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Item price:</label>
                <input type="text" name="price" class="form-control mb-2" placeholder="Enter price" value={!! $item['itemCost'] !!}>  
                @error('price')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Year of production:</label>
                <input type="text" name="year" class="form-control mb-2" placeholder="Enter year of production" value={!! $item['created_year'] !!}>  
                @error('year')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Product image</label> <br>
                <img src="../shopItems/{!! $item['itemImage'] !!}" class="card-img-top w-25 p-2 mb-2" alt="shopItems/{!! $item['itemImage'] !!}">
                <br><input type="checkbox" name="dropImage" class="form-check-input mb-3"> No image</input>
                <input type="file" name="itemImage" class="form-control mb-2 fs-6" placeholder="upload image">  
                @error('itemImage')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>

            <p class="text-center fs-2 mt-3">Services</p>
            <div class="form-group fs-4">
                <label class="mb-2">Warranty</label>
                <select name="warrantyPeriod" class="form-select mb-2">
                    <option value="no" @if ($item['warrantyPeriod'] == null)  {!! "selected" !!} @endif>
                        No warranty
                    </option>
                    <option value="6 months" @if ($item['warrantyPeriod'] == "6 months")  {!! "selected" !!} @endif>
                        6 months
                    </option>
                    <option value="1 year" @if ($item['warrantyPeriod'] == "1 year")  {!! "selected" !!} @endif>
                        1 year
                    </option>
                    <option value="2 years" @if ($item['warrantyPeriod'] == "2 years")  {!! "selected" !!} @endif>
                        2 years
                    </option>
                    <option value="3 years" @if ($item['warrantyPeriod'] == "3 years")  {!! "selected" !!} @endif>
                        3 years
                    </option>
                </select>
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Warranty cost:</label>
                <input type="text" name="warrantyCost" class="form-control mb-2" placeholder="Enter warranty cost" value={!! $item['warrantyCost'] !!}>  
                @error('warrantyCost')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Delivery</label>
                <select name="deliveryPeriod" class="form-select mb-2">
                    <option value="no" @if ($item['deliveryPeriod'] == null)  {!! "selected" !!} @endif>
                        No delivery
                    </option>
                    <option value="1 week" @if ($item['deliveryPeriod'] == "1 week")  {!! "selected" !!} @endif>
                        1 week
                    </option>
                    <option value="8 days" @if ($item['deliveryPeriod'] == "8 days")  {!! "selected" !!} @endif>
                        8 days
                    </option>
                    <option value="9 days" @if ($item['deliveryPeriod'] == "9 days")  {!! "selected" !!} @endif>
                        9 days
                    </option>
                    <option value="10 days" @if ($item['deliveryPeriod'] == "10 days")  {!! "selected" !!} @endif>
                        10 days
                    </option>
                    <option value="15 days" @if ($item['deliveryPeriod'] == "15 days")  {!! "selected" !!} @endif>
                        15 days
                    </option>
                </select>
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Delivery cost:</label>
                <input type="text" name="deliveryCost" class="form-control mb-2" placeholder="Enter delivery cost" value={!! $item['deliveryCost'] !!}>  
                @error('deliveryCost')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Set up cost:</label>
                <input type="text" name="setUpCost" class="form-control mb-2" placeholder="Enter set up cost" value={!! $item['itemSetupCost'] !!}>  
                @error('setUpCost')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-outline-success mt-3 mb-3 py-2 w-50 col-md-3 col-8">Update product</button>    
        </form>
    </div>
@endsection