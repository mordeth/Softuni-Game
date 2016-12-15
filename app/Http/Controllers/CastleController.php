<?php

namespace App\Http\Controllers;

use App\Buildings;
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
        $castle = new Castle();
        $buildings = new Buildings();
        $buildings->checkBuildings();
        $properties = $castle->loadCastle();
        return view('castle')->with('properties', $properties);
    }

    public static function heartbeat() {
        $resources = new Resources();
        $resources->updateResources();
    }
}
