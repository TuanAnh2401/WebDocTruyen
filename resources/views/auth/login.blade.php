@extends('layouts.app')
@section('content')
    <div class="login-form">
        <form method="POST" action="{{ route('login') }}">
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
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <button type="submit">Đăng nhập</button>
            </div>
        </form>
    </div>
@endsection
