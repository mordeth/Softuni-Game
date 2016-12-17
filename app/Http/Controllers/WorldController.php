<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\World;

use App\Resources;

use Auth;

use App\Castle;
use App\Battles;

class WorldController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $castle = new Castle();
        $properties = $castle->loadCastle(true);

        // Check finished units
        $battles = new Battles();
        $battles->checkBattles();

        return view('home')->with('properties', $properties)->with('logged_user', $user_id);
    }
}
