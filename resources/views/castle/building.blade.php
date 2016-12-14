<div class="castle">
    @if ($building->building_level > 0)
        <img src="/svg/{{$building->type}}.svg" class="castle-building-panel" data-tooltip-id="#castle-panel-{{$building->type}}">
		<div class="castle-tooltip" id="castle-panel-{{$building->type}}">
			<a href="#">Update building</a>
		</div>
    @else
        <img src="/svg/{{$building->type}}_outline.svg" class="castle-building-panel" data-tooltip-id="#castle-panel-{{$building->type}}">
        <div class="castle-tooltip" id="castle-panel-{{$building->type}}">
			<a href="#">Build</a>
		</div>
    @endif
</div>
