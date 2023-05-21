<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('email', $user->email)->first();
            if ($findUser) {
                Auth::login($findUser);

                return redirect()->route('dashboard');
            } else {
                return redirect()->route('login')->with('error', 'User '.$user->name.' Belum Terdaftar');
            }
        } catch (\Exception $e) {

            return redirect()->route('login')->with('error', 'Google Login Error '.$e->getMessage());
        }
    }
}
