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
</head>
<body>
    <!--Contenedor principal -->
    <div class="container h-100 profile-container">

        <div class="row pt-3">
            <div class="logout text-end">

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>

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

                    <div class="options">
                        <div class="btn-group-vertical w-100 ">
                            <a href="/edit-profile" class="btn btn-outline-success text-start" >
                                <i class="bi bi-person p-2 pe-3"></i>
                                Edit personal information
                            </a>
                            <a href="/rout-companions" class="btn btn-outline-success text-start">
                                <i class="bi bi-people-fill p-2 pe-3"></i>
                                Route companions
                            </a>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Columna Derecha -->
            <div class="col-6">

                <div class="row h-50 d-flex align-items-center borde">
                    <!-- Contenedor Ruta Actual -->
                    <div class="col mb-4 ">

                        <div class="card edit-card">
                            <div class="card-header section-title">Next Route</div>
                            <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                            <div class="card-body overflow-auto">
                                <ul class="list-group">
                                    @if(isset($routes))
                                        @foreach ( $routes as $route )
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <!-- El span hace que el icono y el texto se mantengan como un mismo elemento distribuido-->
                                                <span><i class="bi bi-map"></i> {{$route['title']}}</span>
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
                    <!-- Contenedor Gestion Seguidas -->
                    <div class="col">

                        <div class="card edit-card">
                            <div class="card-header section-title">Followed Routes</div>
                            <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                            <div class="card-body overflow-auto">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-map"></i> Route 1</span>
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-x"></i></button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-map"></i> Route 2</span>
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-x"></i></button>
                                    </li>

                                    <!-- Añadir más rutas aquí -->
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row h-50 d-flex align-items-center borde">
                    <!-- Contenedor Gestion Rutas Creadas -->
                    <div class="col">

                        <div class="card edit-card">
                            <div class="card-header section-title">Routes Created</div>
                            <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                            <div class="card-body overflow-auto">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-map"></i> Route 1</span>
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-x"></i></button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-map"></i> Route 2</span>
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-x"></i></button>
                                    </li>
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
