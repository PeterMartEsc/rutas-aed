<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class UserController extends Controller{
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
        $this->userRepository = new UserRepository();
    }

    /**
     * Function to show the edit form for the user profile
     * @return view to edit the user profile
     */
    public function indexEditProfile(){
        return view('editUser');
    }

    /**
     * Function to update the data of an user
     * @return redirect to home/dashboard with message
     */
    public function indexUpdateData(Request $request){
        $userUpdate = new User();
        $userUpdate->id = auth()->user()->id;
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


}
