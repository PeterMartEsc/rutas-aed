<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\User;
use App\Repository\RouteRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    protected $routeRepository;
    protected $userRepository;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:Admin');

        $this->routeRepository = new RouteRepository();
        $this->userRepository = new UserRepository();
    }

    public function index(){
        $users = $this->userRepository->findAll();
        $routes = $this->routeRepository->findAll();
        return view('profileAdmin', compact('users', 'routes'));
    }

    /**
     * User management
     */

    /**
      * Function to find all users in the database
      */
    public function findAllUsers(){
        $users = $this->userRepository->findAll();
        return view('profileAdmin', compact('users'));
    }


    /**
      * Function to search for a specific user to edit it
      */
    public function searchUserToEdit($id, $email){
        $user = $this->userRepository->findById($id);

        if($user && $user->email === $email){
            return view('editUser', compact('user'));
        }
    }

    /**
     * Function to edit a user
     */
    public function editUser(Request $request, $id){
        $name = $request->input('name');
        $surname = $request->input('surname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $role = $request->input('role');
        $user = $this->userRepository->update(new User([
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'id_role' => $role,
            'id_image' => null, // TODO: add image upload feature
        ]), $id);

        return redirect()->route('admin.manageUsers')->with('message', 'User updated successfully');
    }



    /**
     * Function to delete a user
     * TODO: if user has routes published the fk on routes must change to null before deleting
     */
    public function deleteUser($id){
        $deleted = $this->userRepository->delete($id);

        $message = "Something went wrong while deleting the user";

        if($deleted){
            $message = "User successfully deleted";
        }

        return redirect()->route('admin.profile')->with('message', $message);;
    }

    /**
     * TODO: admin must have the permission to create, edit and delete a route or user. therefore all users must
     * have the permission to edit their own routes and sign for new routes if there is at least one person signed
     * in for a route it cant be deleted
     */


    /**
     * function to find all routes
     */
    public function findAllRoutes(){
        $routes = $this->routeRepository->findAll();
        return view('adminRoutes', compact('routes'));
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
        $user_id = $request->input('user_id');

        $route = $this->routeRepository->save(new Route([
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

    // TODO: search functional, pfp profile selection
    // sign for routes + signout,
    // if the route is mine i can edit/delete
    // if not mine i can only see/sign for routes
}
