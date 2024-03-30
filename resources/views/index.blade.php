@extends('layouts.app')
@section('content')
<!-- Hero Section Begin -->
<section class="hero">
    <div class="container">
        <div class="hero__slider owl-carousel" id="slider">
            @if(isset($slides) && $slides->count() > 0)
                @foreach ($slides as $slide)
                    <div class="hero__items set-bg" data-setbg="{{ asset($slide->link) }}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="hero__text">
                                    <div class="label">{{ $slide->name }}</div>
                                    <h2>{{ $slide->name }}</h2>
                                    <p>{{ $slide->detail }}</p>
                                    <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No slides found</p>
            @endif
        </div>
    </div>
</section>
<!-- Hero Section End -->
@endsection