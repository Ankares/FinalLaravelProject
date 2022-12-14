@extends('layouts/app')
@section('title')
    Shop
@endsection
@extends('layouts/header')
@section('content')
    <div class="container mt-5 mx-auto relative min-h-screen">
        <div class="search-from mb-3 col-md-11 col-10 offset-1">
            @if (session('success'))
                <div class="alert alert-success col-6 mx-auto mt-5 mb-5 text-center">
                    {!! session('success') !!}
                </div> 
            @endif
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
                @if (empty($filteredData[0]))
                    <p class="fs-4 text-center">There is no products found</p>
                @endif
                @foreach ($filteredData as $item)
                    <div class="product card shadow col-lg-3 offset-lg-1 col-md-5 offset-md-1 col-10 offset-1 mb-5 p-2 position-relative">
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
                            <p class="card-text mb-2">Year: {!! $item['created_year'] !!}</p>
                            <p class="card-text mb-5" data-toggle="tooltip" data-placement="top" title="@foreach($currencies as $currency)@if ($currency['iso'] == 'USD' || $currency['iso'] == 'EUR' || $currency['iso'] == 'RUB') {!! number_format( $item['itemCost'] / $currency['value']) !!} {!! $currency['iso'] !!} @endif @endforeach">
                                Price: {!! number_format($item['itemCost']) !!} BYN
                            </p>  
                            @role('simple-user')
                                <a href="{{route('services', [$item['id']])}}" class="lead btn btn-outline-primary col-12 position-absolute bottom-0 start-0 rounded-0 rounded-bottom">Add for: {!! $item['itemCost'] !!} BYN</a>
                            @endrole
                        </div>
                    </div>
                @endforeach
            @else
                <div id="carouselExampleIndicators" class="carousel slide mb-3 bg-white col-12 shadow-sm" data-ride="carousel">
                    <h2 class="mb-3 ms-3 fs-1 text-center">Top items</h2>
                    <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h4 class="fw-bold text-dark text-center">Acer Aspire 3 A315-34</h4>
                        <div class="text-warning text-center mb-3">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        <img class="d-block w-50 mx-auto mb-3" src="/../shopItems/no/ac/?????????????? Acer Aspire 3 A315-34-P7TD.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <h4 class="fw-bold text-dark text-center">Phillips 43PFS5505</h4>
                        <div class="text-warning text-center mb-3">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <img class="d-block w-50 mx-auto mb-3" src="/../shopItems/te/ph/?????????????????? Philips 43PFS5505.jpeg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <h4 class="fw-bold text-dark text-center">LG 32LM576BPLD</h4>
                        <div class="text-warning text-center mb-3">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        <img class="d-block w-50 mx-auto mb-2" src="/../shopItems/te/lg/?????????????????? LG 32LM576BPLD.jpeg" alt="Third slide">
                    </div>
                    </div>
                    <a class="carousel-control-prev bg-dark" style="width:7%" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next bg-dark" style="width:7%" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="categories border rounded shadow-sm text-center mb-5 pt-3 fs-5">
                    <form action="{{route('categories', ['category' => 'tv'])}}" method="POST" class="col-12 col-md-3 float-md-start">
                        @csrf
                        <input type="hidden" name="category" value="tv">
                        <input type="hidden" name="itemsPerPage" value="9">
                        <button class="bg-transparent link-secondary border-0 text-decoration-underline">TV's</button>
                    </form>
                    <form action="{{route('categories', ['category' => 'laptop'])}}" method="POST" class="col-12 col-md-3 float-md-start">
                        @csrf
                        <input type="hidden" name="category" value="laptop">
                        <input type="hidden" name="itemsPerPage" value="9">
                        <button class="bg-transparent link-secondary border-0 text-decoration-underline">Laptops</button>
                    </form>
                    <form action="{{route('categories', ['category' => 'phone'])}}" method="POST" class="col-12 col-md-3 float-md-start">
                        @csrf
                        <input type="hidden" name="category" value="phone">
                        <input type="hidden" name="itemsPerPage" value="9">
                        <button class="bg-transparent link-secondary border-0 text-decoration-underline">Phones</button>
                    </form>
                    <form action="{{route('categories', ['category' => 'fridge'])}}" method="POST" class="col-12 col-md-3 float-md-start">
                        @csrf
                        <input type="hidden" name="category" value="fridge">
                        <input type="hidden" name="itemsPerPage" value="9">
                        <button class="bg-transparent link-secondary border-0 text-decoration-underline">Fridges</button>
                    </form>
                </div>
                <div class="dropdown text-md-end ms-md-2">
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
                @foreach ($products as $item)
                    <div class="product card shadow col-lg-3 offset-lg-1 col-md-5 offset-md-1 col-10 offset-1 mb-5 p-2 position-relative">
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
                        <img src="/../shopItems/{!! $item['itemImage'] !!}" class="card-img-top p-2" alt="shopItems/{!! $item['itemImage'] !!}">
                        <div class="card-body text-start lead">
                            <h5 class="card-title mb-3">{!! $item['itemName'] !!}</h5>
                            <p class="card-text mb-2">Manufacturer: {!! $item['manufacturer'] !!}</p>
                            <p class="card-text mb-2">Year: {!! $item['created_year'] !!}</p>
                            <p class="card-text mb-5" data-toggle="tooltip" data-placement="top" title="@foreach($currencies as $currency)@if ($currency['iso'] == 'USD' || $currency['iso'] == 'EUR' || $currency['iso'] == 'RUB') {!! number_format( $item['itemCost'] / $currency['value']) !!} {!! $currency['iso'] !!} @endif @endforeach">
                                Price: {!! number_format($item['itemCost']) !!} BYN
                            </p>  
                            @role('simple-user')
                                <a href="{{route('services', [$item['id']])}}" class="lead btn btn-outline-primary col-12 position-absolute bottom-0 start-0 rounded-0 rounded-bottom">Additional Services</a>
                            @endrole
                        </div>
                    </div>
                @endforeach
                <div class="container mb-5 text-center">
                    {!! $products->links() !!} 
                </div>
            @endif
        </div>
    </div>
@endsection
