<!doctype html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login — LuxSkin Beauty</title><link rel="stylesheet" href="{{ asset('css/style.css') }}"></head>
<body class="admin-body"><main class="admin-main" style="max-width:520px;margin:8vh auto;padding:24px"><section class="admin-panel" style="padding:32px"><a class="logo" href="{{ route('admin.login') }}">luxskin<span>.</span></a><p class="eyebrow" style="margin-top:24px">PRIVATE ADMIN ACCESS</p><h1>Admin sign in</h1><p class="muted">Halaman khusus pengelola toko LuxSkin Beauty.</p>
@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="flash">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('admin.login.post') }}">@csrf<label>Email admin<input type="email" name="email" value="{{ old('email') }}" required autofocus></label><label>Password<input type="password" name="password" required></label><button class="btn dark full" style="margin-top:20px">Masuk ke Dashboard ↗</button></form>
<p class="muted" style="margin-top:24px">Bukan admin? <a href="{{ rtrim(config('app.url'), '/') }}">Kembali ke website customer</a></p></section></main></body></html>
