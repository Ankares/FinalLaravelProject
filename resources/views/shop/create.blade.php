@extends('layouts/app')
@section('title')
    Add product
@endsection
@extends('layouts/header')
@section('content')
    <div class="container col-md-6 col-12">
        <p class="text-center display-5 mt-5">Add product</p>
        <form action={{ route('store') }} method="post" enctype="multipart/form-data" class="form-control border shadow-sm mt-4 py-3 px-5 mx-auto justify-content-center">  
            @csrf
            <p class="text-center fs-2 mt-1">Product</p>
            <div class="form-group fs-4">
                <label class="mb-2">Item name:</label>
                <input type="text" name="itemName" class="form-control mb-2" placeholder="Enter item name" value={{ old('itemName') }}>
                @error('itemName')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Manufacturer:</label>
                <input type="text" name="manufacturer" class="form-control mb-2" placeholder="Enter manufacturer" value={{ old('manufacturer') }}>  
                @error('manufacturer')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Item price:</label>
                <input type="text" name="price" class="form-control mb-2" placeholder="Enter price" value={{ old('price') }}>  
                @error('price')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Year of production:</label>
                <input type="text" name="year" class="form-control mb-2" placeholder="Enter year of production" value={{ old('year') }}>  
                @error('year')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Product image</label>
                <input type="file" name="itemImage" class="form-control mb-2 fs-6" placeholder="upload image">  
                @error('itemImage')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>

            <p class="text-center fs-2 mt-3">Services</p>
            <div class="form-group fs-4">
                <label class="mb-2">Warranty</label>
                <select name="warrantyPeriod" class="form-select mb-2">
                    <option value="no">
                        No warranty
                    </option>
                    <option value="6 months">
                        6 months
                    </option>
                    <option value="1 year">
                        1 year
                    </option>
                    <option value="2 years">
                        2 years
                    </option>
                    <option value="3 years">
                        3 years
                    </option>
                </select>
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Warranty cost:</label>
                <input type="text" name="warrantyCost" class="form-control mb-2" placeholder="Enter warranty cost" value={{ old('warrantyCost') }}>  
                @error('warrantyCost')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Delivery</label>
                <select name="deliveryPeriod" class="form-select mb-2">
                    <option value="no">
                        No delivery
                    </option>
                    <option value="1 week">
                        1 week
                    </option>
                    <option value="8 days">
                        8 days
                    </option>
                    <option value="9 days">
                        9 days
                    </option>
                    <option value=" 10 days">
                        10 days
                    </option>
                    <option value="15 days">
                        15 days
                    </option>
                </select>
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Delivery cost:</label>
                <input type="text" name="deliveryCost" class="form-control mb-2" placeholder="Enter delivery cost" value={{ old('deliveryCost') }}>  
                @error('deliveryCost')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Set up cost:</label>
                <input type="text" name="setUpCost" class="form-control mb-2" placeholder="Enter set up cost" value={{ old('setUpCost') }}>  
                @error('setUpCost')  
                    <div class="alert alert-danger mb-2 fs-5"> {{ $message }} </div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-outline-success mt-3 mb-3 py-2 w-50 col-md-3 col-8">Add product</button>    
        </form>
    </div>
@endsection