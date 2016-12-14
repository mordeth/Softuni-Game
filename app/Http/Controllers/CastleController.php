<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Castle;

class CastleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $castle = new Castle;
        $buildings = $castle->loadBuildings();
        return view('castle')->with('buildings', $buildings);
    }
}
