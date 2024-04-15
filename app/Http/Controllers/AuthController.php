<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CtVip;
use App\Models\Price;
use App\Models\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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

        $userRole = Role::where('name', 'user')->first();
        $user->role_id = $userRole->id;
        $user->save();

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
    public function showProfile()
    {
        $user = Auth::user();
        $name = null;
        $endDate = null;
        $ctVip = CtVip::where('user_id', $user->id)->where('is_deleted', false)->first();
        if ($ctVip) {
            $price = Price::find($ctVip->price_id);
            if ($price) {
                $name = $price->name;
                $endDate = $ctVip->end_date;
            }
        }
        return view('auth.profile', compact('user', 'name', 'endDate'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'avatar.image' => 'File phải là một hình ảnh.',
            'avatar.mimes' => 'Chỉ chấp nhận các định dạng hình ảnh JPEG, PNG, JPG hoặc GIF.',
            'avatar.max' => 'Dung lượng tối đa của ảnh là 2MB.',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->name = $request->name;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                File::delete(public_path('storage/avatars/' . $user->avatar));
            }

            $avatarName = uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('storage/avatars'), $avatarName);

            $user->avatar = $avatarName;
        }

        $user->save();

        $request->user()->name = $user->name;
        $request->user()->avatar = $user->avatar;

        return redirect()->route('user.profile')->with('success', 'Cập nhật thông tin tài khoản thành công!');
    }
    public function showPasswordChangeForm()
    {
        return view('auth.change-password');
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('user.profile')->with('success', 'Mật khẩu đã được cập nhật thành công!');
    }
}
