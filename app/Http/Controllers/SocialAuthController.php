<?php

namespace App\Http\Controllers;

    
use App\Models\User;
use App\Models\Role;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
        if (!$user->role_id) {
            $userRole = Role::where('name', 'user')->first();
            if ($userRole) {
                $user->role_id = $userRole->id;
                $user->save();
            }
        }   
        Auth::login($user);
        return redirect('/');
    }
}
