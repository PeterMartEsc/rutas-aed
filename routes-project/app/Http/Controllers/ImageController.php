<?php

namespace App\Http\Controllers;
use App\Repository\RouteRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    protected $routesRepository;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role:User');

        $this->routesRepository = new RouteRepository();
    }

    public function index(){
        return view('image-upload');
    }


    public function uploadImages($routeId, Request $request){
        $route = $this->routesRepository->findById($routeId);

        if($route && $route->date_route < now()){
            $directoryName = $route->title . '_' . Carbon::parse($route->date_route)->format('Y-m-d');
            $path = 'routes/images/' . $directoryName;

            Storage::makeDirectory($path);

            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = Carbon::parse($route->date_route)->format('Y-m-d') . '_' . auth()->user()->name.  '_' .$image->getClientOriginalExtension();
                $image->storeAs($path, $imageName);
            }

        }

        return true;
    }
}



