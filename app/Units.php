<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Auth;

class Units extends Model
{
    public function loadUnits() {
        $units = DB::table('units')
            ->get();

        return $units;
    }

    public function loadArmy() {
        $user_id = Auth::user()->id;
        $army = DB::table('castle_units')
            -where('user_id', $user_id)
            ->get();

        return $army;
    }
}
