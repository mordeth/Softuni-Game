<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Resources;
use Auth;
use Carbon\Carbon;

class Units extends Model
{
    // Load all units
    public function loadUnits() {
        $units = DB::table('units')
            ->get();

        return $units;
    }

    // Load units by type
    public function loadUnitByType($type) {
        $units = DB::table('units')
            ->where('type', $type)
            ->first();

        return $units;
    }

    // Load user army
    public function loadArmy() {
        $user_id = Auth::user()->id;
        $army_units = array();
        $total = 0;

        // Load units from database
        $units = $this->loadUnits();

        foreach($units as $unit) {
            $unit_count = DB::table('castle_units')
                ->where('user_id', $user_id)
                ->where('unit_type', $unit->id)
                ->where('in_progress', false)
                ->sum('number');

            $total = $total + $unit_count;
            $army_units[$unit->type] = $unit_count;
        }

        $army_units['total'] = $total;

        return $army_units;
    }

    public function add() {
        $user_id = Auth::user()->id;

        // Load units by type
        $unit = $this->loadUnitByType($this->type);

        // Load user resources
        $resources = new Resources;
        $resources = $resources->loadResources();

        // Calculate resources required
        $required_food = $unit->required_food * (int) $this->number;
        $required_gold = $unit->required_gold * (int) $this->number;

        // Calculate total time required in seconds
        $required_time = $unit->required_time * (int) $this->number;

        // Check if we have enough resources
        if($required_food > $resources->food || $required_gold > $resources->gold) {
            // We dont have enough resources
            return false;
        }

        // Decrease used resources
        $this->decreaseResource('food', $resources->food - $required_food);
        $this->decreaseResource('gold', $resources->gold - $required_gold);

        // Check if unit already in queue
        $queue = $this->getQueue();
        if(!empty($queue)) {
            $expire = Carbon::parse($queue->end_time);
        } else {
            $expire = Carbon::now('Europe/Sofia');
        }

        $expire->addSeconds($required_time);

        // Add to database
        DB::table('castle_units')->insert([
            [
                'user_id' => $user_id,
                'unit_type' => $unit->id,
                'end_time' => $expire,
                'number' => $this->number,
                'in_progress' => true
            ]
        ]);
    }

    // Decrease used resources
    public function decreaseResource($type, $number) {
        $user_id = Auth::user()->id;
        $builder = DB::table('resources')
            ->where('user_id', $user_id)
            ->update(
                array(
                    $type => $number
                )
            );
    }

    // Get units in queue
    public function getQueue() {
        $user_id = Auth::user()->id;
        $last = DB::table('castle_units')
            ->where('user_id', $user_id)
            ->where('in_progress', true)
            ->orderBy('end_time', 'desc')
            ->first();

        return $last;
    }

    public function checkUnits() {
        $user_id = Auth::user()->id;
        $now = Carbon::now('Europe/Sofia');
        $units = DB::table('castle_units')
            ->where('user_id', $user_id)
            ->where('in_progress', true)
            ->where('end_time', '<', $now)
            ->get();

        foreach($units as $unit) {
            $builder = DB::table('castle_units')
                ->where('user_id', $user_id)
                ->where('id', $unit->id)
                ->update(
                    array(
                        'in_progress' => false
                    )
                );
        }
    }
}
