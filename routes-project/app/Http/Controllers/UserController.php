<?php

namespace App\Http\Controllers;
use App\Repository\RouteRepository;

class UserController extends Controller{
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

    public function indexEditProfile(){
        return view('editUser');
    }

    

}
