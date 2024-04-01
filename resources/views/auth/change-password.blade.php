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

    <!-- Password Change Section Begin -->
    <section class="password-change spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login__form">
                        <h3>Đổi mật khẩu</h3>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @error('current_password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="input__item">
                                <input type="password" name="current_password" placeholder="Mật khẩu hiện tại" required>
                                <span class="icon_lock"></span>
                            </div>

                            <div class="input__item">
                                <input type="password" name="password" placeholder="Mật khẩu mới" required>
                                <span class="icon_lock"></span>
                            </div>

                            <div class="input__item">
                                <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu mới" required>
                                <span class="icon_lock"></span>
                            </div>

                            <button type="submit" class="site-btn">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Password Change Section End -->
@endsection
