<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $http = new \GuzzleHttp\Client(['verify' => false]);
        $response = $http->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri' => config('services.google.redirect'),
                'grant_type' => 'authorization_code',
                'code' => $request->code,
            ],
        ]);
        $data = json_decode((string) $response->getBody(), true);
        $accessToken = $data['access_token'];

        // Get user info
        $response = $http->get('https://www.googleapis.com/oauth2/v3/userinfo', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);
        $googleUser = json_decode((string) $response->getBody(), true);

        // Cari user berdasarkan email, jika tidak ada buat baru
        $user = User::firstOrCreate(
            ['email' => $googleUser['email']],
            [
                'name' => $googleUser['name'],
                'password' => bcrypt(uniqid()), // password random, tidak dipakai
                'role' => 'user', // default role, bisa diubah sesuai kebutuhan
            ]
        );

        Auth::login($user, true);

        // Redirect sesuai role
        if ($user->role === 'admin' || $user->role === 'ustadz') {
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->route('home');
        }
    }
}