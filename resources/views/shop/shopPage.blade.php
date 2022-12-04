@extends('layouts/app')
@section('title')
    Shop
@endsection
@extends('layouts/header')
@section('content')
    <div class="container mt-5 mx-auto relative min-h-screen">
        <div class="search-from mb-3 col-md-11 col-10 offset-1">
            <form action="{{route('filtering')}}" method="post">
                @csrf
                <div class="d-flex justify-content-between ">
                    <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>
        <h2 class="mb-5 mt-5 ms-3 fs-1 text-center">Shop assortment</h2>
        <div class="row mx-auto">
            @if ($filteredData != null)
                @foreach ($filteredData as $item)
                    <div class="product card col-lg-3 offset-lg-1 col-md-5 offset-md-1 col-10 offset-1 mb-5 p-2 position-relative">
                        @role('administrative-user')
                            <div class="d-flex justify-content-between">
                                <form action={{route('edit', [$item['id']])}} method="get">
                                    @csrf
                                    <button class="btn btn-outline-primary px-4">Edit</button>
                                </form>
                                <form action={{route('delete', [$item['id']])}} method="post">
                                    @csrf
                                    <button class="btn btn-outline-danger px-4">Delete</button>
                                </form>
                            </div>
                        @endrole
                        <img src="shopItems/{!! $item['itemImage'] !!}" class="card-img-top p-2" alt="shopItems/{!! $item['itemImage'] !!}">
                        <div class="card-body text-start lead">
                            <h5 class="card-title mb-3">{!! $item['itemName'] !!}</h5>
                            <p class="card-text mb-2">Manufacturer: {!! $item['manufacturer'] !!}</p>
                            <p class="card-text mb-5">Year: {!! $item['created_year'] !!}</p>
                            @role('simple-user')
                                <a href="{{route('services', [$item['id']])}}" class="lead btn btn-outline-primary col-12 position-absolute bottom-0 start-0 rounded-0 rounded-bottom">Add for: {!! $item['itemCost'] !!} BYN</a>
                            @endrole
                        </div>
                    </div>
                @endforeach
            @else
                <div class="dropdown text-md-end">
                    <button class="btn btn-outline-secondary dropdown-toggle col-lg-3 offset-lg-1 col-md-5 offset-md-1 col-10 offset-1 mb-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort by
                    </button>
                    <div class="dropdown-menu text-center shadow col-lg-3 offset-lg-1 col-md-5 offset-md-1 col-10 offset-1" aria-labelledby="dropdownMenuButton">
                        <form action="{{route('filtering')}}" method="post">
                            @csrf
                            <input type="hidden" name="reset" value="on">
                            <button class="dropdown-item">Reset filters</button>
                        </form>
                        <form action="{{route('filtering')}}" method="post">
                            @csrf
                            <input type="hidden" name="itemName-asc" value="on">
                            <button class="dropdown-item">A-Z <i class="fa-solid fa-up-long"></i></button>
                        </form>
                        <hr>
                        <form action="{{route('filtering')}}" method="post">
                            @csrf
                            <input type="hidden" name="itemName-desc" value="on">
                            <button class="dropdown-item">Z-A <i class="fa-solid fa-down-long"></i></button>
                        </form>
                        <hr>
                        <form action="{{route('filtering')}}" method="post">
                            @csrf
                            <input type="hidden" name="itemCost-asc" value="on">
                            <button class="dropdown-item">Price <i class="fa-solid fa-up-long"></i></button>
                        </form>
                        <hr>
                        <form action="{{route('filtering')}}" method="post">
                            @csrf
                            <input type="hidden" name="itemCost-desc" value="on">
                            <button class="dropdown-item">Price <i class="fa-solid fa-down-long"></i></button>
                        </form>
                        <hr>
                        <form action="{{route('filtering')}}" method="post">
                            @csrf
                            <input type="hidden" name="created_year-asc" value="on">
                            <button class="dropdown-item">Year <i class="fa-solid fa-up-long"></i></button>
                        </form>
                        <hr>
                        <form action="{{route('filtering')}}" method="post">
                            @csrf
                            <input type="hidden" name="created_year-desc" value="on">
                            <button class="dropdown-item">Year <i class="fa-solid fa-down-long"></i></button>
                        </form>
                    </div>
                </div>
                @foreach ($data['products'] as $item)
                    <div class="product card col-lg-3 offset-lg-1 col-md-5 offset-md-1 col-10 offset-1 mb-5 p-2 position-relative">
                        @role('administrative-user')
                            <div class="d-flex justify-content-between">
                                <form action={{route('edit', [$item['id']])}} method="get">
                                    @csrf
                                    <button class="btn btn-outline-primary px-4">Edit</button>
                                </form>
                                <form action={{route('delete', [$item['id']])}} method="post">
                                    @csrf
                                    <button class="btn btn-outline-danger px-4">Delete</button>
                                </form>
                            </div>
                        @endrole
                        <img src="shopItems/{!! $item['itemImage'] !!}" class="card-img-top p-2" alt="shopItems/{!! $item['itemImage'] !!}">
                        <div class="card-body text-start lead">
                            <h5 class="card-title mb-3">{!! $item['itemName'] !!}</h5>
                            <p class="card-text mb-2">Manufacturer: {!! $item['manufacturer'] !!}</p>
                            <p class="card-text mb-5">Year: {!! $item['created_year'] !!}</p>
                            @role('simple-user')
                                <a href="{{route('services', [$item['id']])}}" class="lead btn btn-outline-primary col-12 position-absolute bottom-0 start-0 rounded-0 rounded-bottom">Add for: {!! $item['itemCost'] !!} BYN</a>
                            @endrole
                        </div>
                    </div>
                @endforeach
                <div class="container mb-5 text-center">
                    {!! $data['products']->links() !!} 
                </div>
            @endif
        </div>
    </div>
@endsection
