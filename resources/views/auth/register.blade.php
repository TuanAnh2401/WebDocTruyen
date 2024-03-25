@extends('layouts.app')
@section('content')
    <div class="registration-form">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Hiển thị thông báo lỗi -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Nhập lại mật khẩu:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <div class="form-group">
                <button type="submit">Đăng ký</button>
            </div>
        </form>
    </div>
@endsection
