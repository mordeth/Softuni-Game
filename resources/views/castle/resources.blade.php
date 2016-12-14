<div class="requirements">
	<div class="wood"><span class="needed">{{$building->wood_needed + ($building->wood_needed * ($building->building_level * Config::get('constants.building_per_level')))}}</span> / <span class="available">{{$properties['resources']->wood}}</span></div>
	<div class="stone"><span class="needed">{{$building->stone_needed + ($building->stone_needed * ($building->building_level * Config::get('constants.building_per_level')))}}</span> / <span class="available">{{$properties['resources']->stone}}</span></div>
	<div class="time"><span class="needed">{{gmdate("i:s", $building->time_required)}}</span></div>
</div>