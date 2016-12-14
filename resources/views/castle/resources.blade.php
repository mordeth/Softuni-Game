<div class="requirements">
	<span>Wood: {{$building->wood_needed + ($building->wood_needed * ($building->building_level * Config::get('constants.building_per_level')))}} / {{$properties['resources']->wood}}</span>
	<span>Stone: {{$building->stone_needed + ($building->stone_needed * ($building->building_level * Config::get('constants.building_per_level')))}} / {{$properties['resources']->stone}}</span>
</div>