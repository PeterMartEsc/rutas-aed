<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Nabil Leon Alvarez <@nalleon>">
    <meta name="author" content="Pedro Martin Escuela <@PeterMartEsc>">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body style="background-color: #181818 ">
    <div class="container d-flex justify-content-center text-light mt-5 mb-5">
        <div class="card bg-dark custom-shadow text-light rounded mt-3 position-relative w-75 col-10 col-md-6 col-lg-4"  >
            <div class="card-header bg-light text-success">
                <h2 class="text-center m-3 fw-bold text-uppercase">Login</h2>
            </div>
            <div class="card-body">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row justify-content-center align-items-center">
                        <!-- Email Address -->
                        <div class="col-8 col-sm-8 col-md-10 mb-3">
                            <x-input-label for="email" class="form-label fw-bold text-uppercase text-center" :value="__('Email')" />
                            <x-text-input id="email" class="form-control"  type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="col-8 col-sm-8 col-md-10 mb-3">
                            <x-input-label for="password" class="form-label fw-bold text-uppercase text-center" :value="__('Password')" />

                            <x-text-input id="password" class="form-control" 
                                                type="password"
                                                name="password"
                                                required autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="col-8 col-sm-8 col-md-10 mb-3">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="col-8 col-sm-8 col-md-4 d-grid gap-2 mt-2">
                                @if (Route::has('password.request'))
                                    <a class="text-center" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="col-8 col-sm-8 col-md-4 d-grid gap-2 mt-2">
                                <x-primary-button  class="btn btn-success text-uppercase fw-bold">
                                    {{ __('Log in') }}
                                </x-primary-button>
                            </div>
                        </div>
                </form>
        </div>
    </div>
</body>
</html>