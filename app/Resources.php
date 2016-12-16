<?php

namespace App;

use Auth;
use DB;
use Config;
use Carbon\Carbon;
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

    public function updateResources() {
        // Get current time
        $currentTime = Carbon::now('Europe/Sofia');

        // Select all records older than 2 minutes
        $executable = DB::table('resources')
            ->where('updated_at', '<=', $currentTime->subMinutes(2)->toDateTimeString())
            ->get();

        // Build id based on resource
        $resource_types = array(
            'gold' => 3,
            'wood' => 4,
            'stone' => 5,
            'food' => 2
        );

        // Set default timezone
        date_default_timezone_set('Europe/Sofia');

        // Loop all executable rows
        foreach($executable as $row) {
            $newResources = array();
            $current = strtotime("now");
            $last_activity = strtotime($row->updated_at." Europe/Sofia");

            // How old is last record in minutes
            $timeDiff = round(abs($last_activity - $current) / 60);

            foreach($resource_types as $key => $building_id) {
                // Check if building exist
                $building = $this->buildingExist($building_id, $row->user_id);
                if($building) {
                    $newResources[$key] = $this->calculateResource(
                        $row->$key,
                        $building->building_level,
                        $timeDiff);
                }
            }

            // Update resources
            if(!empty($newResources)) {
                $builder = DB::table('resources')
                    ->where('id', '=', $row->id)
                    ->update($newResources);
            }
        }
    }

    // Check if building exist
    public function buildingExist($building_id, $user_id) {
        $buildingExist = DB::table('castle_builds')
            ->where('building_id', $building_id)
            ->where('user_id', $user_id)
            ->where('in_progress', false)
            ->first();

        if(!empty($buildingExist)) {
            return $buildingExist;
        }

        return false;
    }

    // Calculate resources to add
    public function calculateResource($resource, $level, $timeDiff) {
       $perHour = Config::get('constants.resource_per_hour');
       $perLevel = Config::get('constants.resource_per_level');
       $resourcePerTwoMinutes = (int) $perHour * 0.03333;
       $levelResources = (int) $level * $perLevel;
       $forTwoMinutes = $resourcePerTwoMinutes + ($resourcePerTwoMinutes * $levelResources);
       $multiplier = $timeDiff / 2;
       $totalAdded = $forTwoMinutes * $multiplier;

       return $totalAdded + $resource;
    }
}
