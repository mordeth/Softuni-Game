<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Castle;
use App\Resources;

class CastleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $castle = new Castle;
        $resources = new Resources;
        $myresources = $resources->loadResources();
        $buildings = $castle->loadBuildings();
        print_r($buildings);
        return view('castle')->with('buildings', $buildings)->with('myresources', $myresources);
    }
}
