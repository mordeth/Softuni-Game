<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class World extends Model
{
    public function load_castle( $y, $x ) {
        $castle = DB::table('castles')
            ->where('location_x', $x)
            ->where('location_y', $y)
            ->first();

        if( !empty( $castle ) ) {
            return $castle->id;
        }

        return;
    }
}
