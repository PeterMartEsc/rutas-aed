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
        .info{
            height: 300px;
        }

        .options{
            height: 300px;
        }

        .nearest-route, .other-routes{
            border: solid 1px black;

            height: 300px;
            margin: 20px;
            margin-left: 50px;
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="row">
            <div class="col-6 ">

                <div class="info d-flex align-items-center">
                    <img class="p-5" src="" alt="ppp"/>
                    <p class="pe-5"><b>Name: </b>Nombre</p>
                    <p class="pe-5"><b>Surname: </b> Apellidos</p>
                </div>

                <br/>
                <div class="options">
                    <div class="btn-group-vertical w-100 ">
                        <a href="/editPer" class="btn btn-outline-success text-start" >
                            <i class="bi bi-person p-2 pe-3"></i>
                            Edit personal information
                        </a>
                        <a href="/routCompanions" class="btn btn-outline-success text-start">
                            <i class="bi bi-people-fill p-2 pe-3"></i>
                            Route companions
                        </a>
                    </div>
                </div>

            </div>

            <div class="col-6">
                <div class="row">
                    <div class="col nearest-route">

                    </div>
                </div>

                <br/>

                <div class="row">
                    <div class="col other-routes">

                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
