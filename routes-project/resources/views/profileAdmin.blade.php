<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Nabil Leon Alvarez <@nalleon>">
    <meta name="author" content="Pedro Martin Escuela <@PeterMartEsc>">
    <title>Profile Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html, body {
            height: 100%;
        }

        .info{
            height: 300px;
        }

        .edit-users, .edit-routes{
            border: solid 1px black;

            height: 300px;

            align-self:flex-end;
        }

        .edit-card{
            height: 300px;
        }
        /*.borde{
            border: solid 1px black;
        }*/
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
                        <li class="list-group-item m-1 nav-item"><a class="ms-3 link-underline link-underline-opacity-0 link-dark me-1 fw-bold" href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> Profile</a> </li>
                        <li class="list-group-item m-1 nav-item"><a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-light me-1 fw-bold" href="{{ route('routes') }}"><i class="bi bi-tree-fill"></i> Routes</a></li>
                        <li class="list-group-item m-1 nav-item"><a class="ms-3 link-offset-1 link-underline link-underline-opacity-0 link-dark me-1 fw-bold"  href="{{ route('create-route') }}"><i class="bi bi-map-fill"></i></i> Create Routes</a></li>
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
    <!--Contenedor principal -->
    <div class="container h-100 profile-container">



        <div class="row h-100">
            @auth

            <!-- Columna Izquierda-->
            <div class="col-6 ">

                <div class="info d-flex align-items-center">
                    <img class="p-5" src="example.png" alt="ppp"/>
                    <p class="pe-5"><b>Name: </b>{{auth()->user()->name}}</p>
                    <p class="pe-5"><b>Surname: </b> {{auth()->user()->surname}}</p>
                </div>
                <br/>
                <div class="card p-3">
                    @if (session('message'))
                        <p class="text-center"><b>{{ session('message') }}</b></p>
                    @endif

                    <div class="options">
                        <div class="btn-group-vertical w-100 ">
                            <a href="/" class="btn btn-outline-success text-start" >
                                <i class="bi bi-person p-2 pe-3"></i>
                                Edit personal information
                            </a>
                            <a href="{{ route('routes') }}" class="btn btn-outline-success text-start">
                                <i class="bi bi-compass p-2 pe-3"></i>
                                Search Routes
                            </a>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Columna Derecha -->
            <div class="col-6">

                <div class="row h-50 d-flex align-items-center borde">
                    <!-- Contenedor Gestion Usuarios -->
                    <div class="col mb-4 ">

                        <div class="card edit-card">
                            <div class="card-header section-title">Users</div>
                            <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                            <div class="card-body overflow-auto">
                                <ul class="list-group">
                                    @if(isset($users))
                                        @foreach ( $users as $user )
                                        <!-- Usuario de ejemplo -->
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <!-- El span hace que el icono y el texto se mantengan como un mismo elemento distribuido-->
                                            <a href="{{ route('admin.edit.user' , ['user' => $user['id']]) }}" class="text-decoration-none text-dark">
                                                <span><i class="bi bi-person"></i> {{$user['name']}} ({{$user['email']}})</span>
                                            </a>
                                            <button class="btn btn-danger btn-sm"><i class="bi bi-x"></i></button>
                                        </li>
                                        @endforeach
                                    @endif
                                        <!-- Añadir más usuarios aquí -->
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row h-50 d-flex align-items-center borde">
                    <!-- Contenedor Gestion Rutas -->
                    <div class="col">

                        <div class="card edit-card">
                            <div class="card-header section-title">Routes</div>
                            <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                            <div class="card-body overflow-auto">
                                <ul class="list-group">
                                    @if(isset($routes))
                                        @foreach ( $routes as $route )
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><i class="bi bi-map"></i> {{$route['title']}}</span>
                                                <button class="btn btn-danger btn-sm"><i class="bi bi-x"></i></button>
                                            </li>

                                        @endforeach
                                    @endif
                                    <!-- Añadir más rutas aquí -->
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
