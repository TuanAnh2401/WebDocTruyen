@extends('layouts.app')

@section('content')
<!-- Normal Breadcrumb Begin -->
<section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="normal__breadcrumb__text">
                    <h2>Đăng nhập</h2>
                    <p>Chào mừng bạn đến với CAP Anime.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Normal Breadcrumb End -->

<!-- Login Section Begin -->
<section class="login spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login__form">
                    <h3>Đăng nhập</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="input__item">
                            <input type="text" name="login" placeholder="Email hoặc tên tài khoản">
                            <span class="icon_profile"></span>
                        </div>
                        <div class="input__item">
                            <input type="password" name="password" placeholder="Mật khẩu">
                            <span class="icon_lock"></span>
                        </div>
                        <button type="submit" class="site-btn">Đăng nhập</button>
                    </form>
                    <a href="{{ route('password.request') }}" class="forget_pass">Quên mật khẩu?</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login__register">
                    <h3>Bạn chưa có tài khoản?</h3>
                    <a href="{{ route('register') }}" class="primary-btn">Đăng ký ngay</a>
                </div>
            </div>
        </div>
        <div class="login__social">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="login__social__links">
                        <span> hoặc </span>
                        <ul>
                            <li><a href="{{ route('login.provider', 'facebook') }}" class="facebook"><i class="fa fa-facebook"></i> Đăng nhập với Facebook</a></li>
                            <li><a href="{{ route('login.provider', 'google') }}" class="google"><i class="fa fa-google"></i> Đăng nhập với Google</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Section End -->
@endsection
