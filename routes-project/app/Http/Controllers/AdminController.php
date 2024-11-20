<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\User;
use App\Repository\RouteRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    public function searchUserToEdit($id){

        $selecteduser = $this->userRepository->findById($id);
        //dd($selecteduser);
        return view('editUserAdmin', compact('selecteduser'));
    }

    /**
     * Function to edit a user
     */
    public function editUser(Request $request){
        $user = $this->userRepository->findById($request->id);

        $name = $request->input('name');
        $surname = $request->input('surname');
        //$email = $request->input('email');
        $phone = $request->input('phone');
        if($request->password){
            $unhashedpassword = $request->input('password');
            $password = Hash::make($unhashedpassword);
        }
        $role = $request->input('role');

        return redirect()->route('admin.manageUsers')->with('message', 'User updated successfully');
    }



    /**
     * Function to delete a user
     * TODO: if user has routes published the fk on routes must change to null before deleting
     */
    public function deleteUser(Request $request){
        
        $id=3;
        $hasRoutes = $this->routeRepository->findRoutesCreatedByUserId($id);

        if (count($hasRoutes) > 0){

            $message = 'User has routes and therefore cannot be deleted';
        }

        $deleted = $this->userRepository->delete($id);

        $message = "Something went wrong while deleting the user";

        if($deleted){
            $message = "User successfully deleted";
        }

        return redirect()->route('admin.profile')->with('message', $message);
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

}
