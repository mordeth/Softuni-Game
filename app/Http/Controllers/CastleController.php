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
        $castle = new Castle();
        $properties = $castle->loadCastle();
        return view('castle')->with('properties', $properties);
    }

    public function build($type) {
        $castle = new Castle();
        $properties = $castle->loadCastle();
        return view('castle')->with('properties', $properties);
    }

    public function update($type) {
        $castle = new Castle();
        $properties = $castle->loadCastle();
        return view('castle')->with('properties', $properties);
    }
}
