<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;


class GoogleController extends Controller
{
    public function onTapGoogle(Request $request)
    {
        $idToken = $request->input('credential');
        $client = new \Google_Client([
            'client_id' => config('services.google.client_id')
        ]);
        $payload = $client->verifyIdToken($idToken);

        if (!$payload) {
            // Invalid ID token
            return back();
        }
        $findUser = User::where('email', $payload['email'])->first();
        if (!$findUser) {
            return response()->json(
                [
                    'status' => "failed",
                    'message' => "user " . $payload['email'] . " belum terdaftar ",
                    'data' => $findUser
                ]
            );
        }

        Auth::login($findUser);
        return response()->json(
            [
                'status' => "success",
                'message' => "user Berhasil login",
                'data' => $findUser
            ]
        );
    }
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
                return redirect()->route('login')->with('error', 'User ' . $user->name . ' Belum Terdaftar');
            }
        } catch (\Exception $e) {

            return redirect()->route('login')->with('error', 'Google Login Error ' . $e->getMessage());
        }
    }
}
