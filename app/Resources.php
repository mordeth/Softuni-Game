<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    public function loadResources() {
        $user_id = Auth::user()->id;
        $buildings = DB::table('resources')
            ->where('user_id', $user_id)
            ->first();

        return $buildings;
    }
}
