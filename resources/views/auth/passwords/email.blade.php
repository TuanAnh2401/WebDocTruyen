@extends('layouts.app')

@section('content')
    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Quên mật khẩu</h2>
                        <p>Chào mừng bạn đến với CAP Anime.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <section class="signup spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Quên mật khẩu</h3>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @error('email')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="input__item">
                                <input type="email" name="email" placeholder="Email của bạn" value="{{ old('email') }}" required>
                                <span class="icon_mail"></span>
                            </div>
                            <button type="submit" class="site-btn">Gửi liên kết đặt lại mật khẩu</button>
                        </form>
                        <h5>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập!</a></h5>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__social__links">
                        <h3>Đăng nhập với:</h3>
                        <ul>
                            <li><a href="{{ route('login.provider', 'facebook') }}" class="facebook"><i class="fa fa-facebook"></i> Đăng nhập với Facebook</a></li>
                            <li><a href="{{ route('login.provider', 'google') }}" class="google"><i class="fa fa-google"></i> Đăng nhập với Google</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Signup Section End -->
@endsection
