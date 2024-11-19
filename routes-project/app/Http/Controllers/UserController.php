<?php

namespace App\Http\Controllers;
use App\Repository\RouteRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $routeRepository;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:User');

        $this->routeRepository = new RouteRepository();
    }

    public function index(){
        //nearest route
        $nextroute = $this->routeRepository->getNearestDateRoute(auth()->user()->id);
        //filter followed routes
        $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);
        //filter created routes
        $createdroutes = $this->routeRepository->findRoutesCreatedByUserId(auth()->user()->id);

        return view('profile', compact('nextroute', 'followedroutes', 'createdroutes'));
    }

    public function indexEditProfile(){


        return view('editUser');
    }

    public function prepareRoutes(){

        $routes = $this->routeRepository->findAll();

        return view('routes', compact('routes'));
    }


    public function selectRoute(Request $request){
        $selectedid = $request->route_id;
        $selectedroute = $this->routeRepository->findById($selectedid);

        $routes = $this->routeRepository->findAll();
        $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);
        return view('routes', compact('selectedroute', 'routes', 'followedroutes'));
    }

    public function signInForRoute(Request $request){
        $userId = $request->input('userId');
        $routeId = $request->input('routeId');
        $isSigned = $this->routeRepository->signForRoute($userId, $routeId);

        if($isSigned){
            $selectedid = $request->route_id;
            $selectedroute = $this->routeRepository->findById($selectedid);

            $routes = $this->routeRepository->findAll();
            $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);
            dd($followedroutes);
            return view('routes', compact('selectedroute', 'routes', 'followedroutes'));
        }

    }


    public function signOutForRoute(Request $request){
        $userId = $request->input('userId');
        $routeId = $request->input('routeId');

        $isSigned = $this->routeRepository->signOutForRoute($userId, $routeId);

        $aux = $this->routeRepository->getRoutesOrderedByDate($userId);

        if($isSigned){
            $selectedid = $request->route_id;
            $selectedroute = $this->routeRepository->findById($selectedid);

            $routes = $this->routeRepository->findAll();
            $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);
            return view('routes', compact('selectedroute', 'routes', 'followedroutes'));
        }

    }


}
