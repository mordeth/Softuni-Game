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
        $distance = $this->calculateDistance($this->attacker, $this->enemy);

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
        $this->subtractArmy($this->attacker);
    }

    public function calculateDistance($attacker, $defender) {
        $distance = 0;
        $attacker_castle = World::loadCastleById($attacker);
        $defender_castle = World::loadCastleById($defender);

        // Get both castle coordinates
        $coordinate_x = abs($attacker_castle->location_x - $defender_castle->location_x);
        $coordinate_y = abs($attacker_castle->location_y - $defender_castle->location_y);

        // Total path
        $distance = $coordinate_x + $coordinate_y;

        return $distance;
    }

    public function subtractArmy($id) {
        // Delete all army from user castle
        DB::table('castle_units')
            ->where('user_id', '=', $id)
            ->where('in_progress', false)
            ->delete();
    }

    public function attacking() {
        $me = Castle::getCastleID();

        $battle = DB::table('battles')
            ->where('attacker', $me)
            ->first();

        if(!empty($battle)) {
            $battle->defender_name = User::getNameById($battle->defender);
        }

        return $battle;
    }

    public function defending() {
        $me = Castle::getCastleID();

        $battle = DB::table('battles')
            ->where('defender', $me)
            ->first();

        if(!empty($battle)) {
            $battle->attacker_name = User::getNameById($battle->attacker);
        }

        return $battle;
    }

    public function checkBattles() {
        $now = Carbon::now('Europe/Sofia');
        $battles = DB::table('battles')
            ->where('in_progress', 'attack')
            ->where('end_time', '<', $now)
            ->get();

        foreach($battles as $battle) {
            $attackerStats = $this->calculateTotalStats($this->calculateAttackerStats($battle));
            $defenderStats = $this->calculateTotalStats($this->calculateDefenderStats($battle));

            $fight = $this->fight($attackerStats, $defenderStats);

            if($fight['attacker'] < 0) {
                $winner = $battle->defender;
            } else if($fight['defender'] < 0) {
                $winner = $battle->attacker;
            } else {
                if($fight['attacker'] > $fight['defender']) {
                    $winner = $battle->attacker;
                } else if($fight['attacker'] < $fight['defender']) {
                    $winner = $battle->defender;
                } else {
                    $winner = 0;
                }
            }

            if($winner == $battle->attacker) {
                // Attacker wins
                $this->attackerWon($battle, $fight, $attackerStats);
            } else if($winner == $battle->defender) {
                // Defender wins
                $this->defenderWon($battle, $fight, $defenderStats);
            } else {
                $this->draw($battle, $fight, $attackerStats, $defenderStats);
            }
        }
    }

    public function attackerWon($battle, $fight, $stats) {
        $remaining_units = array('in_progress' => 'return', 'winner' => $battle->attacker);
        $survived = $fight['attacker'];
        $survive_percent = ( $survived / $stats['life'] ) * 100;

        $unit_class = new Units();
        $units = $unit_class->loadUnits();

        foreach($units as $unit) {
            $remaining_units['attacker_'.$unit->type] = (int)(($battle->{'attacker_'.$unit->type} * $survive_percent) / 100);
        }

        // Get castle distance
        $distance = $this->calculateDistance($battle->attacker, $battle->defender);

        // Calculate time to reach the destination in seconds
        $timeToDistance = $distance * Config::get('constants.square_time');

        // Set when army reach castle
        $expire = Carbon::now('Europe/Sofia');
        $expire->addSeconds($timeToDistance);

        $remaining_units['end_time'] = $expire;

        $builder = DB::table('battles')
            ->where('id', $battle->id)
            ->update(
                $remaining_units
            );

        // Kill defender army
        $this->subtractArmy($battle->defender);
    }

    public function defenderWon($battle, $fight, $stats) {
        $survived = $fight['defender'];
        $survive_percent = ( $survived / $stats['life'] ) * 100;

        $unit_class = new Units();
        $units = $unit_class->loadUnits();

        // Kill attacker army
        $this->subtractArmy($battle->defender);

        foreach($units as $unit) {
            // Insert Units into DB
            $castle = DB::table('castle_units')->insert([
                array(
                    'unit_type' => $unit->type,
                    'defender' => $this->enemy,
                    'in_progress' => 'false',
                    'number' => (int)(($battle->{'defender_'.$unit->type} * $survive_percent) / 100),
                    'user_id' => $battle->defender
                )
            ]);
        }

        // Kill attacker army
        $this->subtractArmy($battle->attacker);
    }

    public function fight($attacker, $defender) {
        $attacker_round = $attacker['attack'] - $defender['life'];
        $defender_round = $defender['attack'] - $attacker['life'];

        return array(
            'attacker' => $attacker_round,
            'defender' => $defender_round
        );
    }

    public function calculateTotalStats($units) {
        $totalAttack = 0;
        $totalLife = 0;

        foreach($units as $unit) {
            $totalAttack = $totalAttack + $unit['attack'];
            $totalLife = $totalLife + $unit['life'];
        }

        return array(
            'attack' => $totalAttack,
            'life' => $totalLife
        );
    }

    public function calculateAttackerStats($battle) {
        $attacker = array();

        $unit_class = new Units();
        $units = $unit_class->loadUnits();

        foreach($units as $unit) {
            $toughness = $this->calculateToughness($unit->health, $unit->defence);
            $attacker[$unit->type]['attack'] = $battle->{'attacker_'.$unit->type} * $unit->attack;
            $attacker[$unit->type]['life'] = $battle->{'attacker_'.$unit->type} * $toughness;
        }

        return $attacker;
    }

    public function calculateDefenderStats($battle) {
        $defender = array();

        $unit_class = new Units();
        $units = $unit_class->loadUnits();

        foreach($units as $unit) {
            $toughness = $this->calculateToughness($unit->health, $unit->defence);
            $defender[$unit->type]['attack'] = $battle->{'defender_'.$unit->type} * $unit->attack;
            $defender[$unit->type]['life'] = $battle->{'defender_'.$unit->type} * $toughness;
        }

        return $defender;
    }

    // Calculate Toughness, where 1 defence = 0.1 life
    public function calculateToughness($life, $defence) {
        $life_addon = $defence * 0.1;
        $toughness = $life + $life_addon;

        return $toughness;
    }
}
