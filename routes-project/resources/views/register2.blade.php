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
<body>
    <div class="container d-flex justify-content-center text-light mt-5 mb-5">
        <div class="card bg-dark custom-shadow text-light rounded mt-3 position-relative w-75 col-10 col-md-6 col-lg-4"  >
            <div class="card-header bg-light text-success">
                <h2 class="text-center m-3 fw-bold text-uppercase">Register</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST" class="text-center">
                    @csrf
                    @if(session('message'))
                        <p class="text-center text-warning">{{ session('message') }}</p>
                    @endif
                    <div class="row justify-content-center">
                        <div class="col-8 col-sm-8 col-md-10 mb-3">
                            <label for="username" class="form-label fw-bold text-uppercase">Name</label>
                            <input type="text" name="username" id="username" placeholder="Enter your name" class="form-control" required>
                        </div>
    
                            
                        <div class="col-8 col-sm-8 col-md-10 mb-3">
                            <label for="surname" class="form-label fw-bold text-uppercase">Surname</label>
                            <input type="text" name="surname" id="surname" placeholder="Enter your surname" class="form-control" required>
                        </div>
    
                            
                        <div class="col-8 col-sm-8 col-md-10 mb-3">
                            <label for="email" class="form-label fw-bold text-uppercase">Email</label>
                            <input type="email" name="email" id="email" placeholder="Enter your email" class="form-control" required>
                        </div>
    
                        <div class="col-8 col-sm-8 col-md-10 mb-3">
                            <label for="phone" class="form-label fw-bold text-uppercase">Phone</label>
                            <input type="text" name="phone" id="phone" placeholder="Enter your phone number" class="form-control" required>
                        </div>

                        <div class="col-8 col-sm-8 col-md-10 mb-3">
                            <label for="password" class="form-label fw-bold text-uppercase">Password</label>
                            <input type="password" name="password" id="password" placeholder="Enter your password" class="form-control" required>
                        </div>
    
                        <div class="col-8 col-sm-8 col-md-10 mb-3">
                            <label for="password_confirmation" class="form-label fw-bold text-uppercase">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" class="form-control" required>
                        </div>
    
                        <div class="col-8 col-sm-8 col-md-4 d-grid gap-2 mt-2">
                            <button type="submit" class="btn btn-success text-uppercase fw-bold">Register</button>
                        </div>
                    </div>
                    
                    <p class="mt-3">Have an account? <a href="{{ route('login') }}" class="text-decoration-none text-success fw-bold">Click here</a></p>
                </form>
            </div>
        </div>
</body>
</html>