<?php

namespace App\Http\Controllers;
use App\Repository\RouteRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $routesRepository;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:User');

        $this->routesRepository = new RouteRepository();
    }

    public function index(){
        $routes = $this->routesRepository->findAll();
        //filtrado de rutas seguidas
        //filtrado de rutas creadas

        return view('profile', compact('routes'));
    }
}
