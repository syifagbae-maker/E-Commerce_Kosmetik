<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Throwable;

class SocialAuthController extends Controller
{
    // GOOGLE LOGIN
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        return $this->handleCallback('google');
    }

    // FACEBOOK LOGIN
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        return $this->handleCallback('facebook');
    }

    // PROSES LOGIN SOSIAL
    private function handleCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $email = $socialUser->getEmail();

            if (!$email) {
                return redirect()->route('login')
                    ->with('error', 'Email akun tidak tersedia.');
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->getName()
                        ?: $socialUser->getNickname()
                        ?: 'Pengguna LuxSkin',
                    'email' => $email,
                    'password' => bcrypt(Str::random(32)),
                ]);
            }

            Auth::login($user);

            request()->session()->regenerate();

            return redirect()->route('home')
                ->with('success', 'Berhasil masuk ke LuxSkin.');

        } catch (Throwable $e) {

            report($e);

            return redirect()->route('login')
                ->with('error', 'Login sosial gagal. Silakan coba kembali.');
        }
    }
}
