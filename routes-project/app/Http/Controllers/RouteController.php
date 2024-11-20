<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Repository\RouteRepository;
use Illuminate\Http\Request;

class RouteController extends Controller{
    protected $routeRepository;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:User');
        $this->middleware('role:Admin');

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
        
        if (!$isSigned){
            return redirect()->route('routes');
        }

        return redirect()->route('routes');
    }

    /**
     * Show the search form and results.
     */
    public function search(Request $request){
        $filter = $request->input('filter', ''); 
        $routes = [];

        if (!empty($filter)) {
            $routes = $this->routeRepository->filterRoutes($filter);
        } else{
            return redirect()->route('routes');
        }

        return view('routes', compact('routes', 'filter'));
    }


    public function createRouteView(){
        return view('create-route');
    }

    /**
     * Function to create a route
     */
    public function createRoute(Request $request){
        $title = $request->input('title');
        $location = $request->input('location');
        $distance = $request->input('distance');
        $date_route = $request->input('date_route');
        $difficulty = $request->input('difficulty');
        $pets_allowed = $request->input('pets_allowed');
        $vehicle_needed = $request->input('vehicle_needed');
        $description = $request->input('description');
        $user_id = auth()->user()->id;

        $this->routeRepository->save(new Route([
            'title' => $title,
            'location' => $location,
            'distance' => $distance,
            'date_route' => $date_route,
            'difficulty' => $difficulty,
            'pets_allowed' => $pets_allowed,
            'vehicle_needed' => $vehicle_needed,
            'description' => $description,
            'user_id' => $user_id
        ]));

        return redirect()->route('routes');
    }



    /**
     * Function to search for a route to edit
     */
    public function searchRouteToEdit($id, $title){
        $route = $this->routeRepository->findById($id);

        if($route && $route->title === $title){
            return view('editRoute', compact('route'));
        }
    }

    /**
     * Function to edit/update a route
     */
    public function editRoute(Request $request, $id){
        $title = $request->input('title');
        $location = $request->input('location');
        $distance = $request->input('distance');
        $date_route = $request->input('date_route');
        $difficulty = $request->input('difficulty');
        $pets_allowed = $request->input('pets_allowed');
        $vehicle_needed = $request->input('vehicle_needed');
        $description = $request->input('description');
        $user_id = $request->input('user_id');

        $route = $this->routeRepository->update(new Route([
                'id' => $id,
                'title' => $title,
                'location' => $location,
                'distance' => $distance,
                'date_route' => $date_route,
                'difficulty' => $difficulty,
                'pets_allowed' => $pets_allowed,
                'vehicle_needed' => $vehicle_needed,
                'description' => $description,
                'user_id' => $user_id
        ]));

        $message = "Route successfully updated";

        if (!$route){
            $message = "Something went wrong while updating the route";
        }

        return redirect()->route('admin.profile')->with('message', $message);
    }



    /**
     * Function to delete a route
     */
    public function deleteRoute($id){
        $deleted = $this->routeRepository->delete($id);

        $message = "Something went wrong while deleting the route";

        if($deleted){
            $message = "Route successfully deleted";
        }

        return redirect()->route('admin.profile')->with('message', $message);
    }


}
