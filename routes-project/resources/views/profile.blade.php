<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Nabil Leon Alvarez <@nalleon>">
    <meta name="author" content="Pedro Martin Escuela <@PeterMartEsc>">
    <title>Profile User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html, body {
            height: 100%;
        }

        .info {
            height: 300px;
        }

        .edit-card {
            height: 300px;
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
                    <li class="list-group-item m-1 nav-item">
                        <a class="ms-3 link-underline link-underline-opacity-0 link-light me-1 fw-bold" href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door-fill"></i> Profile
                        </a> 
                    </li>
                    <li class="list-group-item m-1 nav-item">
                        <a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-dark me-1 fw-bold" href="{{ route('routes') }}">
                            <i class="bi bi-tree-fill"></i> Routes
                        </a>
                    </li>
                    <li class="list-group-item m-1 nav-item">
                        <a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-dark me-1 fw-bold"  href="{{ route('create-route') }}">
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
<body>

    <!--Contenedor principal -->
    <div class="container h-100 profile-container">
        <div class="row h-100 py-3">
            @auth

            <div class="col-12 col-md-6">
                <div class="info d-flex align-items-center">
                    <img class="p-5" src="example.png" alt="pfp"/>
                    <p class="pe-5"><b>Name: </b>{{auth()->user()->name}}</p>
                    <p class="pe-5"><b>Surname: </b> {{auth()->user()->surname}}</p>
                </div>
                <br/>
                <div class="card p-3 mt-2">
                    <div class="options">
                        <div class="btn-group-vertical w-100 ">
                            <a href="{{route('edit.profile')}}" class="btn btn-outline-success text-start">
                                <i class="bi bi-person p-2 pe-3"></i>
                                Edit personal information
                            </a>
                            <a href="/rout-companions" class="btn btn-outline-success text-start">
                                <i class="bi bi-people-fill p-2 pe-3"></i>
                                Route companions
                            </a>
                            <a href="{{ route('routes') }}" class="btn btn-outline-success text-start">
                                <i class="bi bi-compass p-2 pe-3"></i>
                                Search Routes
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-md-3 col-md-6">
                <div class="row mb-4">
                    <!-- Next Route -->
                    <div class="col-12">
                        <div class="card edit-card">
                            <div class="card-header section-title">Next Route</div>
                            <div class="card-body overflow-auto">
                                <ul class="list-group">
                                    @if(isset($nextroute))
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="bi bi-map"></i> {{$nextroute['title']}}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Followed Routes -->
                    <div class="col-12 mb-md-3 col-md-6">
                        <div class="card edit-card">
                            <div class="card-header section-title">Followed Routes</div>
                            <div class="card-body overflow-auto">
                                <ul class="list-group">
                                    @if(isset($followedroutes))
                                        @foreach ( $followedroutes as $route )
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <form action="{{ route('selected.route') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="route_id" value="{{ $route['id'] }}">
                                                    <button type="submit" class="btn" style="border: none; background: none;">
                                                        <i class="bi bi-map"></i> {{$route['title']}}
                                                    </button>
                                                </form>
                                            </li>   
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Routes Created -->
                    <div class="col-12 mb-md-3 col-md-6"> 
                        <div class="card edit-card">
                            <div class="card-header section-title">Routes Created</div>
                            <div class="card-body overflow-auto">
                                <ul class="list-group">
                                    @if(isset($createdroutes))
                                        @foreach ( $createdroutes as $route )
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <form action="{{ route('edit-route') }}" method="GET" class="d-inline">
                                                    <input type="hidden" name="route_id" value="{{ $route['id'] }}">
                                                    <button type="submit" class="btn" style="border: none; background: none;">
                                                        <i class="bi bi-map"></i> {{$route['title']}}
                                                    </button>
                                                </form>
                                            </li>   
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
