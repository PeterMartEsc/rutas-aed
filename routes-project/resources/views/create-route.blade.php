<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Nabil Leon Alvarez <@nalleon>">
    <meta name="author" content="Pedro Martin Escuela <@PeterMartEsc>">
    <title>Routes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .search, .selected-route{
            margin-top: 80px;

        }

        .routes-list{
            height: 70vh;
        }

        .selected-header{
            height: 34px;
        }

        .selected-image{
            width: 500px;
        }
    </style>
</head>
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
                    <li class="list-group-item m-1 nav-item"><a class="ms-3 link-underline link-underline-opacity-0 link-dark me-1 fw-bold" href="{{ route('user-dashboard') }}"><i class="bi bi-house-door-fill"></i> Profile</a> </li>
                    <li class="list-group-item m-1 nav-item"><a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-dark me-1 fw-bold" href="{{ route('routes') }}"><i class="bi bi-tree-fill"></i> Routes</a></li>
                    <li class="list-group-item m-1 nav-item"><a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-light me-1 fw-bold"  href="{{ route('create-route') }}"><i class="bi bi-map-fill"></i></i> Create Routes</a></li>
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
<body>
    <!--Contenedor principal -->
    <div class="container h-100 profile-container">
        <div class="row">
            <!-- Ruta seleccionada -->
            <div class="col-9 p-2 selected-route">
                <div class="card routes-list">
                    <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                    <div class="card-body overflow-auto">
                        <ul class="list-group">
                            <img src="https://media.traveler.es/photos/635bfa3089708c1dafda9fa3/16:9/w_2560%2Cc_limit/2AMRHB9.jpg"
                            alt="example" class="selected-image mx-auto">
                            <div class="row m-auto">
                                <div class="col-6 p-3">
                                        <label for="where">
                                            <b>Where:</b>
                                            <!<input type="text" name="where" value="" readonly>
                                        </label><br/>
                                        <label for="date">
                                            <b>Date:</b>
                                            <input type="text" name="where" value="" readonly>
                                        </label><br/>
                                        <label for="distance">
                                            <b>Distance:</b>
                                            <input type="text" name="where" value="" readonly>
                                        </label><br/>
                                        <label for="difficulty">
                                            <b>Difficulty:</b>
                                            <input type="text" name="where" value="" readonly>
                                        </label><br/>
                                        <label for="vehicle">
                                            <b>Vehicle:</b>
                                            <label for="yes">
                                                Yes
                                                <input type="radio" name="yesV" id="yesV">
                                            </label>
                                            <label for="no">
                                                No
                                                <input type="radio" name="noV" id="noV" value="0">
                                            </label>
                                        </label><br/>
                                        <label for="vehicle">
                                            <b>Pets:</b>
                                            <label for="yes">
                                                Yes
                                                <input type="radio" name="yesP" id="yesP" value="1">
                                            </label>
                                            <label for="no">
                                                No
                                                <input type="radio" name="noP" id="noP" value="0">
                                            </label>
                                        </label>
                                </div>
                                <div class="text-center mt-4">
                                    <form action="{{route('create-route')}}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="userId" value={{auth()->user()->id}}>
                                        <button type="submit" class="btn btn-success">
                                            Create
                                        </button>
                                    </form>
                
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
