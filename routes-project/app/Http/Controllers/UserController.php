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

        //nearest route
        $nextroute = $this->routesRepository->getNearestDateRoute(auth()->user()->id);
        //filter followed routes
        $followedroutes = $this->routesRepository->getRoutesOrderedByDate(auth()->user()->id);
        //filter created routes
        $createdroutes = $this->routesRepository->findRoutesCreatedByUserId(auth()->user()->id);

        return view('profile', compact('nextroute', 'followedroutes', 'createdroutes'));
    }

    public function prepareRoutes(){

        $routes = $this->getAvailableRoutes();

        return view('routes', compact('routes'));
    }

    public function getAvailableRoutes(){
        //all routes
        $routes = $this->routesRepository->findAll();
        return $routes;
    }

    public function selectRoute(Request $request){
        $selectedid = $request->route_id;
        $selectedroute = $this->routesRepository->findById($selectedid);

        $routes = $this->getAvailableRoutes();

        return view('routes', compact('selectedroute', 'routes'));
    }
}
