<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class World extends Model
{
    public function loadCastles() {
        $castles = DB::table('castles')
            ->leftJoin('users', 'users.id', '=', 'castles.user_id')
            ->get();

        return $castles;
    }
}
