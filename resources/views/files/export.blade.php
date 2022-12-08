@extends('layouts/app')
@section('title')
    Export
@endsection
@extends('layouts/header')
@section('content')
    <div class="container text-center col-10 mx-auto">
        @if (session('success'))
            <div class="alert alert-success col-6 mx-auto mt-5">
                {!! session('success') !!}
            </div> 
        @endif
        @if (!empty($bucketData))
            <div class="fs-2 mt-5 mb-3">
               <p>Bucket: {!! $bucketData->Name !!}</p>
            </div>  
            @if (!empty($filesData))
                @foreach ($filesData as $file)
                    <div class="card px-4 py-3 mt-2 shadow">
                        <p class="lead">{!! $file['fileName'] !!}</p>
                        <p class="text-start">{!! $file['fileContent'] !!}</p>
                    </div> 
                @endforeach    
            @endif    
        @else
            <div class="fs-2 mt-5">
                <p>There is no exported files</p>
            </div>    
        @endif
    </div>
@endsection