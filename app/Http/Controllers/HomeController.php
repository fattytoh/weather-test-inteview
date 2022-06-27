<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function imageLink($filename)
    {
        $path = resource_path() . '/img/' . $filename;

        if(!File::exists($path)) {
            return abort(404);
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    }
}
