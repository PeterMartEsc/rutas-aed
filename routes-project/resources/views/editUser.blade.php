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

        .header-edit{
            margin: auto;
            width: 100vh;
            border: none;
            height: 0;
            margin-bottom: 10px;
        }

        .edit-card{
            height: 140px;
            width: 100vh;
            margin: auto;
        }

        .edit-card2{
            height: 180px;
            width: 100vh;
            margin: auto;
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
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light">
                    <!-- not on use, allows app to translate text to the language selected in the aplication -->
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </nav>
</header>
<body>

    <!--Contenedor principal -->
    <div class="container h-100 profile-container">

        <div class="row">
            @auth
            <div class="row">
                <div class="card mt-2 header-edit p-2">
                    <h5>Edit profile details</h5><br/>
                </div>
            </div>

            <div class="row">

                <div class="col-12 p-4">
                    <div class="card edit-card p-3 bg-light">
                        <h5>Edit profile photo</h5><br/>
                        <form action="" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="id" value="{{auth()->user()->id}}">
                            <button type="submit" class="btn btn-success">
                                Update photo
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 pb-4">
                    <div class="card edit-card2 p-3 bg-light">
                        <h5>Edit personal data</h5><br/>
                        <form action="" method="POST">
                            <label for="name" class="pe-2">
                                <b>Name:</b>
                                <input type="text" name="name" id="name">
                            </label>
                            <label for="surname">
                                <b>Surname:</b>
                                <input type="text" name="surname" id="surname">
                            </label><br/>
                            <button type="submit" class="btn btn-success my-3">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card edit-card2 p-3 bg-light">
                        <h5>Edit password</h5><br/>
                        <form action="" method="POST">
                            <label for="password">
                                <b>New password:</b>
                                <input type="text" name="password" id="password">
                            </label><br/>
                            <button type="submit" class="btn btn-success my-3">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @endauth
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
