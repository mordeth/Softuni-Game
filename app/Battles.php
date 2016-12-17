<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Battles extends Model
{
    // Fight! :)
    public function attack() {
        $this->attacker = Auth::user()->id;

        // Get castle units
        $attacker_units = Units::getCastleUnits($this->attacker);
        $defender_units = Units::getCastleUnits($this->enemy);

        // Get castle distance
        $distance = $this->calculateDistance();

        // Calculate time to reach the destination in seconds
        $timeToDistance = $distance * Config::get('constants.square_time');

        // Set when army reach castle
        $expire = Carbon::now('Europe/Sofia');
        $expire->addSeconds($timeToDistance);

        // If we do not have army, fallback
        if(empty($attacker_units)) {
           return false;
        }

        // Insert Battle into DB
        $castle = DB::table('battles')->insert([
            array(
                'attacker' => $this->attacker,
                'defender' => $this->enemy,
                'in_progress' => 'attack',
                'end_time' => $expire,
                'attacker_archer' => $attacker_units['archer'],
                'attacker_swordsman' => $attacker_units['swordsman'],
                'attacker_knight' => $attacker_units['knight'],
                'defender_archer' => $defender_units['archer'],
                'defender_swordsman' => $defender_units['swordsman'],
                'defender_knight' => $defender_units['knight']
            )
        ]);

        // Remove all army from attacker castle
        $this->subtractAttackerArmy();
    }

    public function calculateDistance() {
        $distance = 0;
        $attacker_castle = World::loadCastleById($this->attacker);
        $defender_castle = World::loadCastleById($this->enemy);

        // Get both castle coordinates
        $coordinate_x = abs($attacker_castle->location_x - $defender_castle->location_x);
        $coordinate_y = abs($attacker_castle->location_y - $defender_castle->location_y);

        // Total path
        $distance = $coordinate_x + $coordinate_y;

        return $distance;
    }

    public function subtractAttackerArmy() {
        // Delete all army from user castle
        DB::table('castle_units')
            ->where('user_id', '=', $this->attacker)
            ->where('in_progress', false)
            ->delete();
    }
}
