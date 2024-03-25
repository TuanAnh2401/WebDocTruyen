<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Tạo user mới
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Chuyển hướng sau khi đăng ký thành công
        return redirect('/')->with('success', 'Đăng ký thành công!');
    }

    // Method để hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Method để xử lý quá trình đăng nhập
    public function login(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Thử đăng nhập với thông tin người dùng nhập vào
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Nếu đăng nhập thành công, chuyển hướng đến route hoặc view mong muốn
            return redirect()->intended('/');
        } else {
            // Nếu đăng nhập thất bại, chuyển hướng trở lại form đăng nhập và hiển thị thông báo lỗi
            return redirect()->back()->withInput($request->only('email'))->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng.',
            ]);
        }
    }

    // Method để đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }
}
