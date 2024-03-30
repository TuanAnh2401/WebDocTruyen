<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'username.required' => 'Vui lòng nhập tên tài khoản.',
            'username.unique' => 'Tên tài khoản đã tồn tại.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký thành công!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        } else {
            if (User::where($loginType, $request->login)->exists()) {
                return redirect()->back()->withInput($request->only('login'))->withErrors([
                    'password' => 'Mật khẩu không đúng.',
                ]);
            } else {
                return redirect()->back()->withInput($request->only('login'))->withErrors([
                    'login' => 'Email hoặc tài khoản không đúng.',
                ]);
            }
        }
    }


    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
    public function showPasswordResetForm()
    {
        return view('auth.passwords.email');
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', 'Chúng tôi đã gửi email liên kết đặt lại mật khẩu của bạn!')
            : back()->withErrors(['email' => 'Đã xảy ra lỗi khi gửi email đặt lại mật khẩu. Vui lòng thử lại sau!']);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        $response = Password::reset($request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        return $response == Password::PASSWORD_RESET
            ? redirect('/login')->with('status', 'Mật khẩu của bạn đã được đặt lại!')
            : back()->withErrors(['email' => ['Đã xảy ra lỗi khi đặt lại mật khẩu.']]);
    }
}
