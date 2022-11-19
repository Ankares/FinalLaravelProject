@extends('layouts/app')
@section('title')
    Shop
@endsection
@extends('layouts/header')
@section('content')
<div class="container mx-auto relative min-h-screen text-center">
    <ul class="list-group">
        <li class="list-group-item offset-md-1 offset-0 col-md-10 col-12 mt-5 mb-5 fs-5 p-4 min-h-fit shadow-sm">
            <p class="text-center mt-2 display-6">Welcome back, {{Auth::user()->name}}</p>
        </li>
    </ul>
</div>
@endsection