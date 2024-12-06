@extends('e-commerce.layouts.layout')

@section('title', 'Page: ' . $Page->title)
@section('section')
<div class="breadcrumb-wrap">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('page',$Page->url_key)}}">{{ $Page->title }}</a></li>
        </ul>
    </div>
</div>

<div class="about-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $Page->title }}</h1>
                <img src="{{ $Page->getFirstMediaUrl('banner_image') }}" alt="About Us" class="img-fluid w-100" style="height: 450px; object-fit: cover;" />

                <div class="col-md-12 mt-4">
                    
                    <p>{!! $Page->description !!}</p>
                </div>
                </div>
        </div>
    </div>
</div>
@endsection
