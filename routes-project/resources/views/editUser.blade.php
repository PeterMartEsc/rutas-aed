<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Nabil Leon Alvarez <@nalleon>">
    <meta name="author" content="Pedro Martin Escuela <@PeterMartEsc>">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            width: 100%;
            max-width: 600px;
        }
    </style>
    <header>
        <nav class="navbar bg-success navbar-expand-md nav-custom">
            <div class="container-fluid ms-3 me-3">
                <a class="navbar-brand text-light" href="{{ route('routes') }}">Rutas-AED</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="d-flex align-items-start navbar-nav me-auto mb-2 mb-lg-0 ms-5">
                        <li class="list-group-item m-1 nav-item">
                            <a class="ms-3 link-underline link-underline-opacity-0 link-dark me-1 fw-bold" href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door-fill"></i> Profile
                            </a>
                        </li>
                        <li class="list-group-item m-1 nav-item">
                            <a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-dark me-1 fw-bold" href="{{ route('routes') }}">
                                <i class="bi bi-tree-fill"></i> Routes
                            </a>
                        </li>
                        <li class="list-group-item m-1 nav-item">
                            <a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-dark me-1 fw-bold" href="{{ route('create-route') }}">
                                <i class="bi bi-map-fill"></i> Create Routes
                            </a>
                        </li>
                    </ul>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-5">
                        @csrf
                        <button type="submit" class="btn btn-outline-light d-flex ms-5">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
</head>
<body>
    <div class="container center-container">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Editing profile</h5>
                <form action="{{ route('dashboard.updated') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="email" name="email" value="{{auth()->user()->email}}">
                    <input type="hidden" id="id_role" name="id_role" value="{{auth()->user()->id_role}}">

                    <div class="col-md-6">
                        <label for="name" class="form-label"><b>Name:</b></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="surname" class="form-label"><b>Surname:</b></label>
                        <input type="text" id="surname" name="surname" class="form-control" placeholder="Enter your surname" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label"><b>Phone:</b></label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone number" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label"><b>Password:</b></label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                    </div>

                    <div class="col-12 text-center mb-3">
                        <input type="hidden" name="user_id">
                        <button type="submit" class="btn btn-success w-100">Edit Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
