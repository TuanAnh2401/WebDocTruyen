@extends('layouts.app')

@section('content')
    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Cập nhật thông tin tài khoản</h2>
                        <p>Chào mừng bạn đến với CAP Anime.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Profile Update Section Begin -->
    <section class="profile-update spad">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Thay đổi thông tin</h3>
                        <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="avatar-wrapper" id="avatar-wrapper">
                                <img src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('img/default-avatar.jpg') }}" alt="Avatar" id="avatar-preview">
                                <input type="file" name="avatar" id="avatar-input" accept="image/*">
                                <label for="avatar-input" class="avatar-label"><i class="fa fa-camera"></i></label>
                            </div>
                            <div class="input__item">
                                <input type="text" name="name" placeholder="Tên của bạn" value="{{ old('name', $user->name) }}" required>
                                <span class="icon_profile"></span>
                            </div>
                            <div class="input__item">
                                <input type="text" name="username" placeholder="Tên tài khoản" value="{{ $user->username }}" readonly>
                                <span class="icon_profile"></span>
                            </div>
                            <div class="input__item">
                                <input type="email" name="email" placeholder="Email" value="{{ $user->email }}" readonly>
                                <span class="icon_mail"></span>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <button type="submit" class="site-btn">Cập nhật thông tin</button>
                            <a href="{{ route('password.change') }}" class="btn  btn-danger">Đổi mật khẩu</a>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="profile-info">
                        <h3 class="text-white" style="margin-bottom: 20px;">Thông tin đăng ký</h3>
                        @if ($name && $endDate)
                            <table class="table">
                                <tr>
                                    <th>Tên dịch vụ</th>
                                    <td>{{ $name }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày kết thúc</th>
                                    <td>{{ $endDate }}</td>
                                </tr>
                            </table>
                            <form action="{{ route('cancel.subscription') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Hủy đăng ký</button>
                            </form>
                        @else
                            <p class="text-white">Chưa đăng ký dịch vụ</p>
                        @endif
                    </div>
                </div>                
            </div>
        </div>
    </section>
    <!-- Profile Update Section End -->
@endsection
