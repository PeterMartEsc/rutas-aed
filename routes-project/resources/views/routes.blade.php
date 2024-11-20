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
            height: 350px;
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
<body>
    

    <!--Contenedor principal -->
    <div class="container h-100 profile-container">

        <div class="row">
            <!-- Lista de rutas -->
            <div class="col-3 p-2 search">
                <div class="card routes-list">
                    <div class="card-header section-title">
                        <form class="d-flex" action="{{ route('routes.search') }}" method="GET" role="search">
                            <input 
                                class="form-control me-2" 
                                type="search" 
                                name="filter" 
                                placeholder="Search" 
                                aria-label="Search" >
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>

                    <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                    <div class="card-body overflow-auto">
                        <ul class="list-group">
                            @if(isset($routes) && count($routes) > 0)
                                @foreach ($routes as $route)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <form action="{{ route('selected.route') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="route_id" value="{{ $route['id'] }}">
                                            <button type="submit" class="btn" style="border: none; background: none;">
                                                <i class="bi bi-map me-2"></i> {{$route['title']}}
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">No routes found matching your search.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Ruta seleccionada -->
            <div class="col-9 p-2 selected-route">
                @if (isset($selectedroute))
                    <div class="card routes-list">
                        <div class="card-header section-title selected-header">
                            <p class="pb-3">
                                @if(isset($selectedroute))
                                    {{$selectedroute['title']}}
                                @endif
                            </p>
                        </div>
                        <div class="card-body overflow-auto">
                            <ul class="list-group">
                                @if(isset($selectedroute))
                                    @php
                                        $imagePath = 'images/' . $selectedroute['title'] . '/' . $selectedroute['title'] . '.png';
                                    @endphp

                                    @if (file_exists(public_path($imagePath))) 
                                        <img src="{{ asset($imagePath) }}" alt="Img {{$selectedroute['title']}}" class="selected-image mx-auto">
                                    @else
                                        <img src="https://media.traveler.es/photos/635bfa3089708c1dafda9fa3/16:9/w_2560%2Cc_limit/2AMRHB9.jpg"
                                            alt="{{$selectedroute['title']}}" class="selected-image mx-auto">
                                    @endif

                            
                                    
                                    <div class="row m-auto">
                                        <div class="col-6 p-3">
                                                <label for="where">
                                                    <b>Where:</b>
                                                    {{$selectedroute['location']}}
                                                </label><br/>
                                                <label for="date">
                                                    <b>Date:</b>
                                                    {{$selectedroute['date_route']}}
                                                </label><br/>
                                                <label for="distance">
                                                    <b>Distance:</b>
                                                    {{$selectedroute['distance']}} km
                                                </label><br/>
                                                <label for="difficulty">
                                                    <b>Difficulty:</b>
                                                    {{$selectedroute['difficulty']}}
                                                </label><br/>
                                                <label for="vehicle">
                                                    <b>Vehicle:</b>
                                                    <label for="yes">
                                                        Yes
                                                        <input type="radio" name="yesV" id="yesV" value="1" {{ $selectedroute['vehicle_needed'] == 1 ? 'checked' : '' }} disabled >
                                                    </label>
                                                    <label for="no">
                                                        No
                                                        <input type="radio" name="noV" id="noV" value="0" {{ $selectedroute['vehicle_needed'] == 0 ? 'checked' : '' }} disabled >
                                                    </label>
                                                </label><br/>
                                                <label for="vehicle">
                                                    <b>Pets:</b>
                                                    <label for="yes">
                                                        Yes
                                                        <input type="radio" name="yesP" id="yesP" value="1" {{ $selectedroute['pets_allowed'] == 1 ? 'checked' : '' }} disabled >
                                                    </label>
                                                    <label for="no">
                                                        No
                                                        <input type="radio" name="noP" id="noP" value="0" {{ $selectedroute['pets_allowed'] == 0 ? 'checked' : '' }} disabled >
                                                    </label>
                                                </label>
                                        </div>

                                        <div class="col-6 p-3">
                                            <h5 class="fw-bold">{{$selectedroute['title']}}</h5>
                                            <p>{{$selectedroute['description']}}</p>

                                        </div>

                                        <div class="text-center mt-4">
                                            @if ($routeIsInMyFollowing)
                                                    <form action="{{route('signout-route')}}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="userId" value={{auth()->user()->id}}>
                                                    <input type="hidden" name="routeId" value={{$selectedroute['id']}}>
                                                    <button type="submit" class="btn btn-danger">
                                                        Sign me out
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{route('sign-route')}}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="userId" value={{auth()->user()->id}}>
                                                    <input type="hidden" name="routeId" value={{$selectedroute['id']}}>
                                                    <button type="submit" class="btn btn-success">
                                                        Sign me in
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </div>
                @elseif(isset($nearestRouteByUser))
                    <div class="card routes-list">
                        <div class="card-header section-title selected-header">
                            <p class="pb-3">
                                @if(isset($nearestRouteByUser))
                                    {{$nearestRouteByUser['title']}}
                                @endif
                            </p>
                        </div>
                        <div class="card-body overflow-auto">
                            <ul class="list-group">
                                @if(isset($nearestRouteByUser))
                                    @php
                                        $imagePath = 'images/' . $nearestRouteByUser['title'] . '/' . $nearestRouteByUser['title'] . '.png';
                                    @endphp

                                    @if (file_exists(public_path($imagePath))) 
                                        <img src="{{ asset($imagePath) }}" alt="Img {{$nearestRouteByUser['title']}}" class="selected-image mx-auto">
                                    @else
                                        <img src="https://media.traveler.es/photos/635bfa3089708c1dafda9fa3/16:9/w_2560%2Cc_limit/2AMRHB9.jpg"
                                            alt="{{$nearestRouteByUser['title']}}" class="selected-image mx-auto">
                                    @endif
                                    <div class="row m-auto">
                                        <div class="col-6 p-3">
                                                <label for="where">
                                                    <b>Where:</b>
                                                    {{$nearestRouteByUser['location']}}
                                                </label><br/>
                                                <label for="date">
                                                    <b>Date:</b>
                                                    {{$nearestRouteByUser['date_route']}}
                                                </label><br/>
                                                <label for="distance">
                                                    <b>Distance:</b>
                                                    {{$nearestRouteByUser['distance']}} km
                                                </label><br/>
                                                <label for="difficulty">
                                                    <b>Difficulty:</b>
                                                    {{$nearestRouteByUser['difficulty']}}
                                                </label><br/>
                                                <label for="vehicle">
                                                    <b>Vehicle:</b>
                                                    <label for="yes">
                                                        Yes
                                                        <input type="radio" name="yesV" id="yesV" value="1" {{ $nearestRouteByUser['vehicle_needed'] == 1 ? 'checked' : '' }} disabled >
                                                    </label>
                                                    <label for="no">
                                                        No
                                                        <input type="radio" name="noV" id="noV" value="0" {{ $nearestRouteByUser['vehicle_needed'] == 0 ? 'checked' : '' }} disabled >
                                                    </label>
                                                </label><br/>
                                                <label for="vehicle">
                                                    <b>Pets:</b>
                                                    <label for="yes">
                                                        Yes
                                                        <input type="radio" name="yesP" id="yesP" value="1" {{ $nearestRouteByUser['pets_allowed'] == 1 ? 'checked' : '' }} disabled >
                                                    </label>
                                                    <label for="no">
                                                        No
                                                        <input type="radio" name="noP" id="noP" value="0" {{ $nearestRouteByUser['pets_allowed'] == 0 ? 'checked' : '' }} disabled >
                                                    </label>
                                                </label>
                                        </div>

                                        <div class="col-6 p-3">
                                            <h5 class="fw-bold">{{$nearestRouteByUser['title']}}</h5>
                                            <p>{{$nearestRouteByUser['description']}}</p>

                                        </div>

                                        <div class="text-center mt-4">
                                            @if ($routeIsInMyFollowing)
                                                    <form action="{{route('signout-route')}}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="userId" value={{auth()->user()->id}}>
                                                    <input type="hidden" name="routeId" value={{$nearestRouteByUser['id']}}>
                                                    <button type="submit" class="btn btn-danger">
                                                        Sign me out
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{route('sign-route')}}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="userId" value={{auth()->user()->id}}>
                                                    <input type="hidden" name="routeId" value={{$nearestRouteByUser['id']}}>
                                                    <button type="submit" class="btn btn-success">
                                                        Sign me in
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="card routes-list">
                        <div class="card-header section-title selected-header">
                            <p class="pb-3">
                                @if(isset($nearestRouteGlobally))
                                    {{$nearestRouteGlobally['title']}}
                                @endif
                            </p>
                        </div>
                        <div class="card-body overflow-auto">
                            <ul class="list-group">
                                @if(isset($nearestRouteGlobally))
                                @php
                                    $imagePath = 'images/' . $nearestRouteGlobally['title'] . '/' . $nearestRouteGlobally['title'] . '.png';
                                @endphp

                                @if (file_exists(public_path($imagePath))) 
                                    <img src="{{ asset($imagePath) }}" alt="Img {{$nearestRouteGlobally['title']}}" class="selected-image mx-auto">
                                @else
                                    <img src="https://media.traveler.es/photos/635bfa3089708c1dafda9fa3/16:9/w_2560%2Cc_limit/2AMRHB9.jpg"
                                        alt="{{$nearestRouteGlobally['title']}}" class="selected-image mx-auto">
                                @endif
                                    <div class="row m-auto">
                                        <div class="col-6 p-3">
                                                <label for="where">
                                                    <b>Where:</b>
                                                    {{$nearestRouteGlobally['location']}}
                                                </label><br/>
                                                <label for="date">
                                                    <b>Date:</b>
                                                    {{$nearestRouteGlobally['date_route']}}
                                                </label><br/>
                                                <label for="distance">
                                                    <b>Distance:</b>
                                                    {{$nearestRouteGlobally['distance']}} km
                                                </label><br/>
                                                <label for="difficulty">
                                                    <b>Difficulty:</b>
                                                    {{$nearestRouteGlobally['difficulty']}}
                                                </label><br/>
                                                <label for="vehicle">
                                                    <b>Vehicle:</b>
                                                    <label for="yes">
                                                        Yes
                                                        <input type="radio" name="yesV" id="yesV" value="1" {{ $nearestRouteGlobally['vehicle_needed'] == 1 ? 'checked' : '' }} disabled >
                                                    </label>
                                                    <label for="no">
                                                        No
                                                        <input type="radio" name="noV" id="noV" value="0" {{ $nearestRouteGlobally['vehicle_needed'] == 0 ? 'checked' : '' }} disabled >
                                                    </label>
                                                </label><br/>
                                                <label for="vehicle">
                                                    <b>Pets:</b>
                                                    <label for="yes">
                                                        Yes
                                                        <input type="radio" name="yesP" id="yesP" value="1" {{ $nearestRouteGlobally['pets_allowed'] == 1 ? 'checked' : '' }} disabled >
                                                    </label>
                                                    <label for="no">
                                                        No
                                                        <input type="radio" name="noP" id="noP" value="0" {{ $nearestRouteGlobally['pets_allowed'] == 0 ? 'checked' : '' }} disabled >
                                                    </label>
                                                </label>
                                        </div>

                                        <div class="col-6 p-3">
                                            <h5 class="fw-bold">{{$nearestRouteGlobally['title']}}</h5>
                                            <p>{{$nearestRouteGlobally['description']}}</p>

                                        </div>

                                    </div>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
