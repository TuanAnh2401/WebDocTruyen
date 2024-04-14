<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

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

        $randomPassword = Str::random(16);

        $user = User::firstOrCreate(
            ['email' => $socialiteUser->getEmail()],
            [
                'name' => $socialiteUser->getName(),
                'username' => $socialiteUser->getEmail(),
                'email' => $socialiteUser->getEmail(),
                'password' => bcrypt($randomPassword)
            ]
        );

        Auth::login($user);
        return redirect('/');
    }
}
