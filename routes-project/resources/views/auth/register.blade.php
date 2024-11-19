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
                <h2 class="text-center m-3 fw-bold text-uppercase">Register</h2>
            </div>
            <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row justify-content-center align-items-center">
                    <!-- Name -->
                    <div class="col-8 col-sm-8 col-md-10 mb-3">
                        <x-input-label for="name" class="form-label fw-bold text-uppercase" :value="__('Name')" />
                        <x-text-input id="name"  type="text" name="name" :value="old('name')"  class="form-control" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Surname -->
                    <div class="col-8 col-sm-8 col-md-10 mb-3">
                        <x-input-label for="surname" class="form-label fw-bold text-uppercase" :value="__('Surname')" />
                        <x-text-input id="surname" type="text" name="surname" :value="old('surname')"  class="form-control" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="col-8 col-sm-8 col-md-10 mb-3">
                        <x-input-label for="email" class="form-label fw-bold text-uppercase" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')"  class="form-control" required autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone number -->
                    <div class="col-8 col-sm-8 col-md-10 mb-3">
                        <x-input-label for="phone" class="form-label fw-bold text-uppercase text-center" :value="__('Phone number')" />
                        <x-text-input id="phone" type="text" name="phone" :value="old('phone')"  class="form-control" required autofocus autocomplete="phonenum" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="col-8 col-sm-8 col-md-10 mb-3">
                        <x-input-label for="password" class="form-label fw-bold text-uppercase" :value="__('Password')" />

                        <x-text-input id="password" class="form-control"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password"  />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-8 col-sm-8 col-md-10 mb-3">
                        <x-input-label for="password_confirmation" class="form-label fw-bold text-uppercase text-center" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="form-control"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="col-8 col-sm-8 col-md-4 d-grid gap-2 mt-2">
                        <x-primary-button  class="btn btn-success text-uppercase fw-bold">
                            {{ __('Register') }}
                        </x-primary-button>

                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                            Already registered?
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
