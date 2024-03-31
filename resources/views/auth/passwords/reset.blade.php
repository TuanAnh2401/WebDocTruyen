@extends('layouts.app')
@section('content')
    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Đổi mật khẩu</h2>
                        <p>Chào mừng bạn đến với CAP Anime.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Change Password Section Begin -->
    <section class="signup spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Đổi mật khẩu</h3>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                            </div>
                            @endif
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="input__item">
                                <input type="password" name="password" placeholder="Mật khẩu mới" required>
                                <span class="icon_lock"></span>
                            </div>
                            <div class="input__item">
                                <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu mới" required>
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" class="site-btn">Đổi mật khẩu</button>
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
    <!-- Change Password Section End -->
@endsection
