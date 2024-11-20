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

}
