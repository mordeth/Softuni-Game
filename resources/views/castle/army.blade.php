<div id="army">
	<table>
		<tr>
			@foreach($properties['army']['units'] as $unit)
			@if($building->building_level < $unit->building_level)
				<td class="not-enough-level" data-level="{{$unit->building_level}}">
			@else
				<td>
			@endif
				<h4>{{$unit->name}}</h4>
				<div class="wrapper">
					<div class="available">{{$properties['army']['available'][$unit->type] ? $properties['army']['available'][$unit->type] : 0}}</div>
					<img src="/images/{{$unit->type}}.png" alt="Archer">
					<div class="stats">
						<div class="stat damage">{{$unit->attack}}</div>
						<div class="stat defence">{{$unit->defence}}</div>
						<div class="stat life">{{$unit->health}}</div>
					</div>
				</div>
				<div class="add-unit">
					<div class="unit-requirements">
						<div class="required gold">{{$unit->required_gold}}</div>
						<div class="required food">{{$unit->required_food}}</div>
						<div class="required time">{{gmdate("i:s", $unit->required_time)}}</div>
					</div>
					<div class="unit-control">
						<a href="/castle/units/add/{{$unit->type}}/1">1</a>
						<a href="/castle/units/add/{{$unit->type}}/5">5</a>
						<a href="/castle/units/add/{{$unit->type}}/10">10</a>
					</div>
				</div>
			</td>
			@endforeach
		</tr>
	</table>
</div>