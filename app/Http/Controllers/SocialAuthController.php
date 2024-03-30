<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Đã xảy ra lỗi khi đăng nhập từ ' . ucfirst($provider) . '.');
        }

        $user = User::where('email', $socialiteUser->getEmail())->first();

        if (!$user) {
            $user = new User();
            $user->name = $socialiteUser->getName();
            $user->username = $socialiteUser->getEmail();
            $user->email = $socialiteUser->getEmail();
            $user->password = bcrypt($socialiteUser->getEmail());
            $user->save();
        }

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng nhập thành công!');
    }
}

