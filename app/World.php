<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class World extends Model
{
    public function loadCastles() {
        $castles = DB::table('castles')->get();

        return $castles;
    }
}
