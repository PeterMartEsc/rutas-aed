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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form action="{{ route('user-dashboard') }}" method="GET" class="d-inline">
                <button type="submit" class="btn btn-outline-light">
                    Profile
                </button>
            </form>
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
                                aria-label="Search" 
                                value="{{ request('filter') }}">
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
                                                <img src="" alt="{{$route['id']}}"> {{$route['title']}}
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
                        <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                        <div class="card-body overflow-auto">
                            <ul class="list-group">
                                @if(isset($selectedroute))
                                    <img src="https://media.traveler.es/photos/635bfa3089708c1dafda9fa3/16:9/w_2560%2Cc_limit/2AMRHB9.jpg"
                                    alt="{{$selectedroute['id']}}" class="selected-image mx-auto">
                                    <div class="row m-auto">
                                        <div class="col-6 p-3">
                                                <label for="where">
                                                    <b>Where:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
                                                    {{$selectedroute['location']}}
                                                </label><br/>
                                                <label for="date">
                                                    <b>Date:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
                                                    {{$selectedroute['date_route']}}
                                                </label><br/>
                                                <label for="distance">
                                                    <b>Distance:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
                                                    {{$selectedroute['distance']}} km
                                                </label><br/>
                                                <label for="difficulty">
                                                    <b>Difficulty:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
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
                                            <p>{{$selectedroute['title']}}</p>
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
                        <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                        <div class="card-body overflow-auto">
                            <ul class="list-group">
                                @if(isset($nearestRouteByUser))
                                    <img src="https://media.traveler.es/photos/635bfa3089708c1dafda9fa3/16:9/w_2560%2Cc_limit/2AMRHB9.jpg"
                                    alt="{{$nearestRouteByUser['id']}}" class="selected-image mx-auto">
                                    <div class="row m-auto">
                                        <div class="col-6 p-3">
                                                <label for="where">
                                                    <b>Where:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
                                                    {{$nearestRouteByUser['location']}}
                                                </label><br/>
                                                <label for="date">
                                                    <b>Date:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
                                                    {{$nearestRouteByUser['date_route']}}
                                                </label><br/>
                                                <label for="distance">
                                                    <b>Distance:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
                                                    {{$nearestRouteByUser['distance']}} km
                                                </label><br/>
                                                <label for="difficulty">
                                                    <b>Difficulty:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
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
                                            <p>{{$nearestRouteByUser['title']}}</p>
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
                        <!-- overflow-auto habilita el scroll si el contenido excede el tamaño del contenedor -->
                        <div class="card-body overflow-auto">
                            <ul class="list-group">
                                @if(isset($nearestRouteGlobally))
                                    <img src="https://media.traveler.es/photos/635bfa3089708c1dafda9fa3/16:9/w_2560%2Cc_limit/2AMRHB9.jpg"
                                    alt="{{$nearestRouteGlobally['id']}}" class="selected-image mx-auto">
                                    <div class="row m-auto">
                                        <div class="col-6 p-3">
                                                <label for="where">
                                                    <b>Where:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
                                                    {{$nearestRouteGlobally['location']}}
                                                </label><br/>
                                                <label for="date">
                                                    <b>Date:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
                                                    {{$nearestRouteGlobally['date_route']}}
                                                </label><br/>
                                                <label for="distance">
                                                    <b>Distance:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
                                                    {{$nearestRouteGlobally['distance']}} km
                                                </label><br/>
                                                <label for="difficulty">
                                                    <b>Difficulty:</b>
                                                    <!--<input type="text" name="where" value="" readonly>-->
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
                                            <p>{{$nearestRouteGlobally['title']}}</p>
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
