<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\User;
use App\Repository\RouteRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class RouteController extends Controller{

    /**
     *  Properties
     */
    protected $routeRepository;
    protected $userRepository;

    /**
     * Default constructor
     */
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:User');
        $this->middleware('role:Admin');

        $this->userRepository = new UserRepository();
        $this->routeRepository = new RouteRepository();
    }

    /**
     * Function to show the home/dashboard of an user
     * @return view based on the user's role
     */

    public function index(){
        $user = Auth::user();
        $role = $user->role->name ?? null;

        if($role == 'Admin'){
            $users = $this->userRepository->findAll();
            $routes = $this->routeRepository->findAll();
            $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);
            return view('profileAdmin', compact('users', 'routes',  'followedroutes'));
        }

        $nextroute = $this->routeRepository->getNearestDateRouteByUser(auth()->user()->id);
        $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);
        $createdroutes = $this->routeRepository->findRoutesCreatedByUserId(auth()->user()->id);

        return view('profile', compact('nextroute', 'followedroutes', 'createdroutes'));
    }


    /**
     * Function to prepare the data to show of all routes
     * @return view to routes with all routes, nearest route globally and the nearest route for the user
     */
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

    /**
     * Function to select a route to show its details
     * @param Request of the route
     * @return view routes with the details of the selected route
     */
    public function selectRoute(Request $request){
        $selectedid = $request->route_id;
        $selectedroute = $this->routeRepository->findById($selectedid);

        $routes = $this->routeRepository->findAll();
        $followedroutes = $this->routeRepository->getRoutesOrderedByDate(auth()->user()->id);

        $routeIsInMyFollowing = false;

        if($selectedroute == null){
            return view('routes', compact('selectedroute', 'routes', 'followedroutes', 'routeIsInMyFollowing'));
        }

        foreach($followedroutes as $followedRoute){
            if($followedRoute['id'] == $selectedroute['id']){
                $routeIsInMyFollowing = true;
                break;
            }
        }

        return view('routes', compact('selectedroute', 'routes', 'followedroutes', 'routeIsInMyFollowing'));
    }

    /**
     * Function to sign in for a route
     * @param Request of the route 
     * @return view routes
     */
    public function signInForRoute(Request $request){
        $userId = $request->input('userId');
        $routeId = $request->input('routeId');
        $isSigned = $this->routeRepository->signForRoute($userId, $routeId);

        if (!$isSigned){
            return redirect()->route('routes');
        }

        return redirect()->route('routes');

    }

    /**
     * Function to sign out of a route
     * @param Request of the route 
     * @return view routes
     */
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
     * @param Request $request
     * @return view routes with the filtered routes
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

    /**
     * Function to show the create route form 
     * @return view create-route 
     */
    public function createRouteView(){
        return view('create-route');
    }

    /**
     * Function to create a route
     * @param Request $request
     * @return redirect to routes page with success message if the route was created successfully, otherwise, redirects to the create route view.
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

        $route = $this->routeRepository->findByUniqueKey($title);

        $this->uploadRouteMainImage($route, $request);

        return redirect()->route('routes');
    }



    /**
     * Function to search for a route to edit
     * @param Request $request
     * @return view edit-route with the route to edit
     */
    public function searchRouteToEdit(Request $request){
        $id = $request->input('route_id');
        $route = $this->routeRepository->findById($id);

        if($route){
            return view('edit-route', compact('route'));
        }
        return redirect()->route('dashboard');
    }

    /**
     * Function to edit/update a route
     * @param Request $request
     * @return redirect to routes page with success message if the route was updated successfully, otherwise, redirects to the edit route view.
     */
    public function editRoute(Request $request){
        $id = $request->input('route_id');
        $title = $request->input('title');
        $location = $request->input('location');
        $distance = $request->input('distance');
        $date_route = $request->input('date_route');
        $difficulty = $request->input('difficulty');
        $pets_allowed = $request->input('pets_allowed');
        $vehicle_needed = $request->input('vehicle_needed');
        $description = $request->input('description');
        $user_id = auth()->user()->id;

        $user = Auth::user();
        $role = $user->role->name ?? null;

        if($role ==! 'Admin'){
            $checkIfIsMine = $this->routeRepository->checkIfRouteIsMine($user_id, $id);
            if(!$checkIfIsMine){
                $message = "Route is not yours to edit";
                return redirect()->route('routes')->with('message', $message);
            }
        }

        $routeUpdate = new Route();
        $routeUpdate->id = $id;
        $routeUpdate->title = $title;
        $routeUpdate->location = $location;
        $routeUpdate->distance = $distance;
        $routeUpdate->date_route = $date_route;
        $routeUpdate->difficulty = $difficulty;
        $routeUpdate->pets_allowed = $pets_allowed;
        $routeUpdate->vehicle_needed = $vehicle_needed;
        $routeUpdate->description = $description;
        $routeUpdate->user_id = $user_id;

        $route = $this->routeRepository->update($routeUpdate);

        $route = $this->routeRepository->findById($id);
        $this->uploadRouteMainImage($route, $request);

        $message = "Route successfully updated";

        if (!$route){
            $message = "Something went wrong while updating the route";
        }

        return redirect()->route('routes')->with('message', $message);
    }



    /**
     * Function to delete a route
     * @param Request $request
     * @return redirect to routes page with success message if the route was deleted successfully, otherwise, redirects to the dashboard.
     */
    public function deleteRoute(Request $request){
        $id = $request->input('route_id');
        $checkIfRouteHasUsers = $this->routeRepository->checkIfRouteHasUsersSigned($id);

        if($checkIfRouteHasUsers){
            $message = "Route cannot be deleted because it has users signed up";
            return redirect()->route('dashboard')->with('message', $message);
        }

        $deleted = $this->routeRepository->delete($id);

        $message = "Something went wrong while deleting the route";

        if($deleted){
            $message = "Route successfully deleted";
        }

        return redirect()->route('routes')->with('message', $message);
    }

    /**
     * Function to upload the route main image 
     * @param Route $route route to save an image for
     * @param Request $request request with image file
     * @return bool true if image was uploaded successfully, false otherwise  (if route is null or request does not contain image file)
     */
    public function uploadRouteMainImage(Route $route, Request $request) {
        if(!$route) {
            return false;
        }

        $directoryName = $route->title;
        $path = public_path('images/' . $directoryName);

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = $route->title . '.' . $image->getClientOriginalExtension();
            $image->move($path, $imageName);

            return true;
        }

        return false;
    }



    /**
     * Function to upload a image after a route has been finished
     * @param Route $route to save an image for
     * @param Request $request with the image file
     * @return bool true if image was uploaded successfully, false otherwise  (if route is null or request does not contain image file)
     */
    public function uploadImagesAfterFinished(Route $route, Request $request){
        if(!$route){
            return false;
        }

        if ($route->date_route > now()){
            return false;
        }

        $directoryName = $route->title;
        $path = public_path('images/' . $directoryName);

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $user = Auth::user();
            $imageName = $user->name . '_'. $user->id  . '_' .$route->title. '_'. $image->getClientOriginalName();
            $image->move($path, $imageName);
            return true;
        }

        return false;
    }
}
