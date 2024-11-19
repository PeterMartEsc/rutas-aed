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
        $nextroute = $this->routeRepository->getNearestDateRouteByUser(auth()->user()->id);
        $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);
        $createdroutes = $this->routeRepository->findRoutesCreatedByUserId(auth()->user()->id);

        return view('profile', compact('nextroute', 'followedroutes', 'createdroutes'));
    }

    public function prepareRoutes(){
        $routes = $this->routeRepository->findAll();
        $nearestRouteByUser = $this->routeRepository->getNearestDateRouteByUser(auth()->user()->id);
        $nearestRouteGlobally = $this->routeRepository->getNearestDateRouteGlobally();


        $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);
        $routeIsInMyFollowing = false;
        
        foreach($followedroutes as $followedRoute){
            if($followedRoute['id'] == $nearestRouteByUser['id']){
                $routeIsInMyFollowing = true;
                break;
            }
        }

        return view('routes', compact('routes', 'nearestRouteByUser', 'nearestRouteGlobally', 'routeIsInMyFollowing'));
    }


    public function selectRoute(Request $request){
        $selectedid = $request->route_id;
        $selectedroute = $this->routeRepository->findById($selectedid);        

        $routes = $this->routeRepository->findAll();
        $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);

        $routeIsInMyFollowing = false;

        foreach($followedroutes as $followedRoute){ 
            if($followedRoute['id'] == $selectedroute['id']){
                $routeIsInMyFollowing = true;
                break;
            }
        }

        return view('routes', compact('selectedroute', 'routes', 'followedroutes', 'routeIsInMyFollowing'));
    }

    public function signInForRoute(Request $request){
        $userId = $request->input('userId');
        $routeId = $request->input('routeId');
        $isSigned = $this->routeRepository->signForRoute($userId, $routeId);


        if (!$isSigned){
            return redirect()->route('routes');
        }

        return redirect()->route('routes');

    }


    public function signOutForRoute(Request $request){
        $userId = $request->input('userId');
        $routeId = $request->input('routeId');

        $isSigned = $this->routeRepository->signOutForRoute($userId, $routeId);

        $aux = $this->routeRepository->getRoutesOrderedByDate($userId);

        
        if (!$isSigned){
            return redirect()->route('routes');
        }

        return redirect()->route('routes');

    }


}
