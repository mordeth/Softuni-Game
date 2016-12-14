<div class="castle">
    @if ($building->building_level > 0 && $building->in_progress == false)
        <img src="/svg/{{$building->type}}.svg" class="castle-building-panel" data-tooltip-id="#castle-panel-{{$building->type}}">
		
    @else
        <img src="/svg/{{$building->type}}_outline.svg" class="castle-building-panel" data-tooltip-id="#castle-panel-{{$building->type}}">
    @endif


	<div class="castle-tooltip" id="castle-panel-{{$building->type}}">
		@if ($building->updateable)
			@include('castle/resources')

				@if ($building->building_level > 0)
					<a href="/castle/update/{{$building->type}}">Update</a>
				@else
					<a href="/castle/build/{{$building->type}}">Build It</a>
				@endif
		@else
			{{$building->name}}
		@endif
	</div>

	@if ($building->in_progress)
		@include('castle/counter')
	@endif
</div>
