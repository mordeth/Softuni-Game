<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;
use Config;
use Carbon\Carbon;

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
            $expire = Carbon::now('Europe/Sofia');
            $expire->addSeconds($building_data->time_required);

            DB::table('castle_builds')->insert([
                [
                    'user_id' => $user_id,
                    'building_level' => '1',
                    'building_id' => $building_data->id,
                    'end_time' => $expire,
                    'in_progress' => true
                ]
            ]);

            DB::table('resources')
                ->where('user_id', $user_id)
                ->update(
                    array(
                        'stone' => $resources['stone'],
                        'wood' => $resources['wood'],
                    )
                );
        }
    }

    public function enoughResources($stone, $wood) {
        $user_id = Auth::user()->id;
        $resources  = DB::table('resources')
            ->where('user_id', $user_id)
            ->first();

        if($resources->stone >= $stone && $resources->wood >= $wood ) {
            // Return remaining resources
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

        // If already in_progress return
        if($building->in_progress) {
            return;
        }

        $stone_needed = $building_data->stone_needed + ($building_data->stone_needed * ($building->building_level * Config::get('constants.building_per_level')));
        $wood_needed = $building_data->wood_needed + ($building_data->wood_needed * ($building->building_level * Config::get('constants.building_per_level')));

        $resources = $this->enoughResources($stone_needed, $wood_needed);

        if($resources) {
            $expire = Carbon::now('Europe/Sofia');
            $expire->addSeconds($building_data->time_required);

            DB::table('castle_builds')
                ->where('user_id', $user_id)
                ->where('building_id', $building->building_id)
                ->update(
                    array(
                        'user_id' => $user_id,
                        'building_level' => $building->building_level + 1,
                        'end_time' => $expire,
                        'in_progress' => true
                    )
                );

            DB::table('resources')
                ->where('user_id', $user_id)
                ->update(array('stone' => $resources['stone'], 'wood' => $resources['wood']));
        }
    }

    public function checkBuildings() {
        $user_id = Auth::user()->id;
        $now = Carbon::now('Europe/Sofia');
        $buildings = DB::table('castle_builds')
            ->where('user_id', $user_id)
            ->where('in_progress', true)
            ->where('end_time', '<', $now)
            ->get();

        foreach($buildings as $building) {
            $builder = DB::table('castle_builds')
                ->where('user_id', $user_id)
                ->where('id', $building->id)
                ->update(
                    array(
                        'in_progress' => false
                    )
                );
        }
    }
}
