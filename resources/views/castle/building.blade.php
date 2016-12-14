<div class="castle">
    @if ($building->building_level > 0)
        <img src="/svg/{{$building->type}}.svg" class="castle-building-panel" data-tooltip-id="#castle-panel-{{$building->type}}">
		<div class="castle-tooltip" id="castle-panel-{{$building->type}}">
			<div class="requirements">
				<span>Wood: {{$building->wood_needed}} / {{$myresources->wood}}</span>
				<span>Stone: {{$building->stone_needed}} / {{$myresources->stone}}</span>
			</div>
			<a href="#">Update</a>
		</div>
    @else
        <img src="/svg/{{$building->type}}_outline.svg" class="castle-building-panel" data-tooltip-id="#castle-panel-{{$building->type}}">
        <div class="castle-tooltip" id="castle-panel-{{$building->type}}">
			<div class="requirements">
				<span>Wood: {{$building->wood_needed}} / {{$myresources->wood}}</span>
				<span>Stone: {{$building->stone_needed}} / {{$myresources->stone}}</span>
			</div>
			<a href="#">Build It</a>
		</div>
    @endif
</div>
