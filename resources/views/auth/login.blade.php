
@extends('layouts.app')

@section('title', 'Masuk Akun — LuxSkin')

@section('content')

<div class="lux-login-page">

    <div class="lux-login-container">

        {{-- PANEL GAMBAR KIRI --}}
        <div class="lux-login-image">

            <img
                src="https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?auto=format&fit=crop&w=1000&q=85"
                alt="LuxSkin Skincare Collection">

            <div class="lux-image-overlay">
                <span>YOUR BEAUTY, YOUR RULES</span>
                <h1>Healthy and radiant<br>skin every day.</h1>
                <p>Discover your everyday beauty essentials.</p>
            </div>

        </div>

        {{-- PANEL FORM KANAN --}}
        <div class="lux-login-form">

            <div class="lux-form-heading">
                <span>WELCOME BACK</span>
                <h2>Login</h2>
                <p>Welcome back! Please enter your details.</p>
            </div>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="lux-alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('error'))
                <div class="lux-alert">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('status'))
                <div class="lux-success">
                    {{ session('status') }}
                </div>
            @endif

            {{-- FORM LOGIN --}}
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="lux-input-group">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email address"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required>
                </div>

                <div class="lux-input-group lux-password-group">
                    <input
                        type="password"
                        name="password"
                        id="luxPassword"
                        placeholder="Password"
                        autocomplete="current-password"
                        required>

                    <button type="button" id="luxShowPassword">
                        Lihat
                    </button>
                </div>

                <div class="lux-forgot">
                    <a href="{{ route('login') }}">Need help signing in?</a>
                </div>

                <button type="submit" class="lux-login-button">
                    Login
                </button>

            </form>

            {{-- SOCIAL LOGIN --}}
            <div class="lux-social-login">

                @if (Route::has('google.login'))
                    <a href="{{ route('google.login') }}"
                       class="lux-social-button">
                        <span class="lux-google-icon">G</span>
                        Login with Google
                    </a>
                @endif

                @if (Route::has('facebook.login'))
                    <a href="{{ route('facebook.login') }}"
                       class="lux-social-button">
                        <span class="lux-facebook-icon">f</span>
                        Login with Facebook
                    </a>
                @endif

            </div>

            {{-- REGISTER --}}
            <div class="lux-register-text">
                Don't have an account?
                <a href="{{ route('register') }}">Sign up</a>
            </div>

            <div class="lux-login-copyright">
                © {{ date('Y') }} LuxSkin Beauty
            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('luxPassword');
    const button = document.getElementById('luxShowPassword');

    if (password && button) {
        button.addEventListener('click', function () {

            if (password.type === 'password') {
                password.type = 'text';
                button.textContent = 'Sembunyikan';
            } else {
                password.type = 'password';
                button.textContent = 'Lihat';
            }

        });
    }

});
</script>

<style>
/* KHUSUS HALAMAN LOGIN LUXSKIN */

.lux-login-page {
    background: #fff5f6 !important;
}

.lux-login-container {
    background: #ffffff !important;
    border: 1px solid #f2dfe2 !important;
    box-shadow: 0 12px 40px rgba(190, 120, 135, 0.10) !important;
}

.lux-login-form {
    background: #ffffff !important;
}

.lux-form-heading h2 {
    color: #302329 !important;
}

.lux-form-heading > span {
    color: #c27d8b !important;
}

.lux-form-heading p {
    color: #8c7c80 !important;
}

.lux-input-group {
    background: #ffffff !important;
    border: 1px solid #efdde1 !important;
    border-radius: 5px !important;
    box-shadow: none !important;
}

.lux-input-group:focus-within {
    border-color: #d49aa5 !important;
}

.lux-password-group button {
    color: #c27d8b !important;
}

.lux-forgot a {
    color: #a18e93 !important;
}

/* TOMBOL LOGIN PINK */

.lux-login-form .lux-login-button {
    background: #c77f8d !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 5px !important;
    height: 49px !important;
}

.lux-login-form .lux-login-button:hover {
    background: #ae6878 !important;
}

/* GOOGLE DAN FACEBOOK */

.lux-social-button {
    background: #ffffff !important;
    color: #40333a !important;
    border: 1px solid #efdde1 !important;
    border-radius: 5px !important;
}

.lux-social-button:hover {
    background: #fff5f6 !important;
    border-color: #c77f8d !important;
}

.lux-register-text {
    color: #89777e !important;
}

.lux-register-text a {
    color: #c77f8d !important;
}

.lux-login-copyright {
    border-color: #f1e5e7 !important;
    color: #a18e93 !important;
}

.lux-alert {
    background: #fff0f1 !important;
    color: #a33d50 !important;
}

.lux-success {
    background: #eff8ef !important;
    color: #39744c !important;
}
/* FINAL COLOR LUXSKIN */

.soco-login-page,
.soco-login-wrapper {
    background: #F4EEE8 !important;
}

.soco-login-card {
    background: #FFFFFF !important;
    border-color: #E9DED5 !important;
}

.soco-login-submit,
.soco-submit {
    background: #403633 !important;
    color: #FFFFFF !important;
}

.soco-login-page input {
    background: #FFFFFF !important;
    border-color: #E9DED5 !important;
}

.soco-login-page a {
    color: #B98272 !important;
}
</style>

<style>
/* PAKSA WARNA LOGIN MENGIKUTI HOMEPAGE LUXSKIN */

html,
body {
    background: #F5F0EA !important;
}

.soco-login-page {
    background: #F5F0EA !important;
    background-color: #F5F0EA !important;
}

.soco-login-visual,
.soco-login-left,
.soco-login-wrapper {
    background-color: #F5F0EA !important;
}

.soco-login-card {
    background: #FFFFFF !important;
    border-color: #E9E0D8 !important;
}

/* TOMBOL LOGIN COKELAT */
.soco-login-page .soco-submit {
    background: #403631 !important;
    background-color: #403631 !important;
    color: #FFFFFF !important;
    border: none !important;
}

/* HOVER TOMBOL */
.soco-login-page .soco-submit:hover {
    background: #59483F !important;
}

/* INPUT */
.soco-login-page .soco-field input {
    background: #FFFFFF !important;
    border: 1px solid #E7DED7 !important;
}

/* AKSEN DUSTY ROSE */
.soco-card-heading span,
.soco-login-tabs a.active,
.soco-password button,
.soco-login-page a:hover {
    color: #A77B6C !important;
}

/* BORDER INPUT */
.soco-login-page .soco-field input:focus {
    border-color: #A77B6C !important;
    outline: none !important;
}

/* TOMBOL GOOGLE DAN FACEBOOK */
.soco-login-page .soco-google,
.soco-login-page .soco-facebook {
    background: #FFFFFF !important;
    border: 1px solid #E7DED7 !important;
    color: #403631 !important;
}
</style>

@endsection
