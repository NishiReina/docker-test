<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginWithGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver("google")->redirect();
    }

    public function authGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::firstOrCreate([
            'email' => $googleUser->email
        ], [
            "name" => $googleUser->name,
            "email" => $googleUser->email,
            'email_verified_at' => now(),
            "password" => "123456dummy",
            'google_id' => $googleUser->getId()
        ]);
        Auth::login($user, true);
        return redirect('/');
    }
}