<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Nabil Leon Alvarez <@nalleon>">
    <meta name="author" content="Pedro Martin Escuela <@PeterMartEsc>">
    <title>Create Route</title>
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
</head>
<body>
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
                            <a class="ms-3 link-underline link-underline-opacity-0 link-dark me-1 fw-bold" href="{{ route('user-dashboard') }}">
                                <i class="bi bi-house-door-fill"></i> Profile
                            </a>
                        </li>
                        <li class="list-group-item m-1 nav-item">
                            <a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-dark me-1 fw-bold" href="{{ route('routes') }}">
                                <i class="bi bi-tree-fill"></i> Routes
                            </a>
                        </li>
                        <li class="list-group-item m-1 nav-item">
                            <a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-light me-1 fw-bold" href="{{ route('create-route') }}">
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
    <div class="container center-container">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Create a New Route</h5>
                <form action="{{ route('save-route') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <label for="title" class="form-label"><b>Title:</b></label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter route title" required>
                    </div>
                    <div class="col-12">
                        <label for="image" class="form-label"><b>Upload Image:</b></label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label"><b>Where:</b></label>
                        <input type="text" id="location" name="location" class="form-control" placeholder="Location" required>
                    </div>
                    <div class="col-md-6">
                        <label for="date_route" class="form-label"><b>Date:</b></label>
                        <input type="date" id="date_route" name="date_route" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="distance" class="form-label"><b>Distance:</b></label>
                        <input type="number" id="distance" name="distance" class="form-control" placeholder="Distance in km" required>
                    </div>
                    <div class="col-md-6">
                        <label for="difficulty" class="form-label"><b>Difficulty:</b></label>
                        <input type="number" id="difficulty" name="difficulty" class="form-control" placeholder="Enter difficulty level" min="1" max="10" required>
                    </div>
                    <div class="col-md-6">
                        <label><b>Vehicle:</b></label><br>
                        <label class="me-3">
                            <input type="radio" name="vehicle_needed" value="1" required> Yes
                        </label>
                        <label>
                            <input type="radio" name="vehicle_needed" value="0" required> No
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label><b>Pets:</b></label><br>
                        <label class="me-3">
                            <input type="radio" name="pets_allowed" value="1" required> Yes
                        </label>
                        <label>
                            <input type="radio" name="pets_allowed" value="0" required> No
                        </label>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label"><b>Description:</b></label>
                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter route description" required></textarea>
                    </div>
                    <div class="col-12 text-center mb-3">
                        <button type="submit" class="btn btn-success w-100">Create Route</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
