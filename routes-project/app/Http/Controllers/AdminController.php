<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Repository\RouteRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class AdminController extends Controller
{

    /**
     * Properties
     */
    protected $routeRepository;
    protected $userRepository;

    /**
     * Default constructor
     */
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:Admin');

        $this->routeRepository = new RouteRepository();
        $this->userRepository = new UserRepository();
    }

    /**
      * Function to search for a specific user to edit it
      * @param $id id of the user to edit
      * @return view with the user data to be edited
      */
    public function searchUserToEdit($id){
        $selecteduser = $this->userRepository->findById($id);

        return view('editUserAdmin', compact('selecteduser'));
    }

    /**
     * Function to edit a user
     * @return redirect to dashboard/home with message
     */
    public function editUser(Request $request){

        $userUpdate = new User();
        $userUpdate->id = $request->input('user_id');
        $userUpdate->name = $request->input('name');
        $userUpdate->surname = $request->input('surname');
        $userUpdate->email = $request->input('email');
        $userUpdate->phone = $request->input('phone');
        $userUpdate->id_role = $request->input('id_role');

        if(!empty($request->input('password'))){
            $unhashedpassword = $request->input('password');
            $password = Hash::make($unhashedpassword);
            $userUpdate->password = $password;
        } else {
            $userAux = $this->userRepository->findById($userUpdate->id);
            $userUpdate->password = $userAux->password;
        }

        $this->userRepository->update($userUpdate);

        return redirect()->route('dashboard')->with('message', 'User updated successfully');
    }



    /**
     * Function to delete a user
     * @return redirect to dashboard/home with message
     */
    public function deleteUser(Request $request){

        $id = $request->input('user_id');
        $hasRoutes = $this->routeRepository->findRoutesCreatedByUserId($id);

        if (count($hasRoutes) > 0){
            $message = 'User has routes and therefore cannot be deleted';
            return redirect()->route('dashboard')->with('message', $message);
        }

        $deleted = $this->userRepository->delete($id);

        $message = "Something went wrong while deleting the user";

        if($deleted){
            $message = "User successfully deleted";
        }

        return redirect()->route('dashboard')->with('message', $message);
    }

    public function indexEditProfile(){
        return view('editUser');
    }

}
