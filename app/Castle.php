<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Castle extends Model
{
    /**
     * Create user castle
     *
     * @return \Illuminate\Http\Response
     */
    public function createCastle($user_id)
    {
        // Get castle random position
        $position = $this->randomPosition();

        // Insert castle into DB
        $castle = DB::table('castles')->insert([
            ['user_id' => $user_id, 'location_x' => $position[0], 'location_y' => $position[1]]
        ]);

        // Add starting resources for the castle
        $this->addResource($user_id);

        // Add default buildings
        $this->addBuildings($user_id);

        return $castle;
    }

    public function randomPosition() {
        $x = rand(1, 10);
        $y = rand(1, 7);

        if($this->isCastleExist($x, $y)) {
            return $this->randomPosition();
        }

        return array($x, $y);
    }

    public function isCastleExist($x, $y) {
        $isCastleExist = DB::table('castles')
            ->where('location_x', $x)
            ->where('location_y', $y)
            ->first();

        if( !empty( $isCastleExist ) ) {
            return $castle->id;
        }

        return false;
    }

    public function addResource($user_id) {
        // Insert castle into DB
        $resources = DB::table('resources')->insert([
            ['user_id' => $user_id, 'gold' => '1000', 'food' => '1000', 'wood' => '1000', 'stone' => '1000']
        ]);
    }

    public function addBuildings($user_id) {
        // Insert castle into DB
        $building = DB::table('castle_builds')->insert([
            ['user_id' => $user_id, 'building_level' => '1', 'building_id' => '1']
        ]);
    }

    public function loadBuildings() {
        $buildings = DB::table('buildings')
            ->leftJoin('castle_builds', 'buildings.id', '=', 'castle_builds.building_id')
            ->get();

        return $buildings;
    }

    public function loadCastle($includeCastles = false) {

        $resources = new Resources;
        $myresources = $resources->loadResources();

        if($includeCastles == true) {
            $world = new World;
            $castles = $world->loadCastles();

            return array(
                'resources' => $myresources,
                'castles' => $castles,
            );
        } else {
            $castle = new Castle;
            $buildings = $castle->loadBuildings();

            return array(
                'resources' => $myresources,
                'buildings' => $buildings,
            );
        }
    }
}
