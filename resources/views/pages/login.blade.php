<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @include('customs.bootstrap5')
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;"> 
            <h2 class="text-center mb-4">@lang('lang.login')</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="@lang('lang.email_placeholder')">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="@lang('lang.password_placeholder')">
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn btn-dark w-100">@lang('lang.login')</button>
                <div class="text-center mt-3">
                    <p>@lang('lang.dont_have_account') <a href="{{ route('registerPage') }}" class="text-decoration-none">@lang('lang.register')</a></p>
                </div>
            </form>
            <div class="text-center mt-3">
                <p class="mb-0">
                    @lang('lang.back_to')
                    <a href="{{ route('homePage') }}" class="text-decoration-none">@lang('lang.home')</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>