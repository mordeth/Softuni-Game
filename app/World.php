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

    public static function loadCastleById($id) {
        $castle = DB::table('castles')
            ->where('id', $id)
            ->first();

        return $castle;
    }

    public static function getUserByCastle($id) {
        $castle = DB::table('castles')
            ->where('id', $id)
            ->first();

        return $castle->user_id;
    }
}
