<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CAP Anime</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/plyr.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
</head>

<body>
    @include('layouts.header')

    <main>
        @yield('content')
        <div id="vipForm" class="container mt-3">
            <div class="custom-header d-flex justify-content-between align-items-center mb-3">
                <h2 class="mr-auto text-dark">Đăng ký gói VIP</h2>
                <span class="close-button btn btn-danger">&times;</span>
            </div>
            <div class="price-list row">
                @foreach ($prices as $price)
                <div class="col-md-{{ 12 / count($prices) }} mb-3">
                    <button class="price-button btn btn-outline-primary w-100" 
                        data-detail="{{ $price->detail}}" 
                        data-price="{{ $price->price }}"
                        data-price-sale="{{ $price->price_sale }}"
                        data-price-id="{{ $price->id }}">
                        <h3>{{ $price->name }}</h3>
                        @if ($price->price_sale)
                            <p class="mb-0 price-info">
                                <del class="original-price">{{ $price->price }}</del>
                                <span class="text-danger sale-price">{{ $price->price_sale }}</span>
                            </p>
                        @else
                            <p class="mb-0 price-info">
                                <span class="original-price">{{ $price->price }}</span>
                            </p>
                        @endif
                    </button>
                </div>
                @endforeach
            </div>
            <div id="priceDetail" class="row mt-3" style="display: none;">
                <div class="col-md-12">
                    <div class="price-detail bg-light p-3">
                        <p id="priceDetailContent"></p>
                    </div>
                </div>
            </div>
            @if ($errors->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if ($errors->has('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ $errors->first('warning') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        
            <div class="text-center mt-3">
                <form id="paymentForm" action="{{ route('payment.vnpay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount" id="amount" value="0">
                    <input type="hidden" name="price_id" id="price_id" value="">
                    <button type="submit" class="btn btn-success">Đăng ký</button>
                </form>
            </div>
        </div>           
    </main>
    @include('layouts.footer')
    <!-- Js Plugins -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/player.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
