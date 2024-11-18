<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Repository\RouteRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    protected $routesRepository;
    protected $userRepository;

    public function __construct(){
        $this->middleware('auth'); 
        $this->middleware('role:Admin');

        $this->routesRepository = new RouteRepository();
        $this->userRepository = new UserRepository();  
    }

    public function index(){
        return view('profileAdmin');
    }

    /**
     * TODO: admin must have the permission to create, edit and delete a route or user. therefore all users must
     * have the permission to edit their own routes and sign for new routes if there is at least one person signed 
     * in for a route it cant be deleted
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
        $user_id = $request->input('user_id');

        $route = $this->routesRepository->save(new Route([
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

        if($route){
            $message = "Route successfully created";
        } else {
            $message = "Error creating route";
        }

        return redirect()->route('admin.index')->with('message', $message);
    }



    public function searchRouteToEdit($id, $title){
        $route = $this->routesRepository->findById($id);
        
        if($route && $route->title === $title){
            return view('editRoute', compact('route'));
        }
    }



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

        $route = $this->routesRepository->update(new Route([
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

    public function deleteRoute($id){
        $deleted = $this->routesRepository->delete($id);

        $message = "Something went wrong while deleting the route";

        if($deleted){
            $message = "Route successfully deleted";
        }


        return redirect()->route('admin.profile')->with('message', $message);
    }
}
