<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;

class Buildings extends Model
{
    public function index() {

    }

    public function build() {
        $user_id = Auth::user()->id;

        // Get building data
        $building_data  = DB::table('buildings')
            ->where('type', $this->type)
            ->first();

        $resources = $this->enoughResources($building_data->stone_needed, $building_data->wood_needed);

        if($resources) {
            DB::table('castle_builds')->insert([
                ['user_id' => $user_id, 'building_level' => '1', 'building_id' => $building_data->id]
            ]);

            DB::table('resources')
                ->where('user_id', $user_id)
                ->update(array('stone' => $resources['stone'], 'wood' => $resources['wood']));
        }
    }

    public function enoughResources($stone, $wood) {
        $user_id = Auth::user()->id;
        $resources  = DB::table('resources')
            ->where('user_id', $user_id)
            ->first();

        if($resources->stone >= $stone && $resources->wood >= $wood ) {
            return array(
                'wood' => $resources->wood - $wood,
                'stone' => $resources->stone - $stone
            );
        }

        return false;
    }

    public function building_update() {
        $user_id = Auth::user()->id;

        // Get building data
        $building_data  = DB::table('buildings')
            ->where('type', $this->type)
            ->first();

        $building  = DB::table('castle_builds')
            ->where('building_id', $building_data->id)
            ->where('user_id', $user_id)
            ->first();

        $resources = $this->enoughResources($building_data->stone_needed, $building_data->wood_needed);

        if($resources) {
            DB::table('castle_builds')
                ->where('user_id', $user_id)
                ->where('building_id', $building->building_id)
                ->update(array('user_id' => $user_id, 'building_level' => $building->building_level + 1));

            DB::table('resources')
                ->where('user_id', $user_id)
                ->update(array('stone' => $resources['stone'], 'wood' => $resources['wood']));
        }
    }
}
