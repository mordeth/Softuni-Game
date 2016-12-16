<div class="castle">
    @if ($building->building_level > 0 && $building->in_progress == false)
        <img src="/svg/{{$building->type}}.svg" class="castle-building-panel" data-tooltip-id="#castle-panel-{{$building->type}}">
		
    @else
        <img src="/svg/{{$building->type}}_outline.svg" class="castle-building-panel" data-tooltip-id="#castle-panel-{{$building->type}}">
    @endif


	<div class="castle-tooltip" id="castle-panel-{{$building->type}}">
		@if ($building->updateable)
			<h5>{{$building->name}} - {{ $building->in_progress == true ? $building->building_level - 1 : $building->building_level}}</h5>
			@include('castle/resources')

			@if ($building->in_progress != true)
				@if ($building->building_level > 0)
				    <a href="/castle/update/{{$building->type}}" class="panel-button">Update to {{$building->building_level + 1}}</a>
					@if ($building->type == "fortress")
						<a href="#army" class="army-button lightbox">Manage Army</a>
					@endif
				@else
					<a href="/castle/build/{{$building->type}}" class="panel-button">Build it</a>
				@endif
			@endif
		@else
			<h5>{{$building->name}}</h5>
		@endif
	</div>

	@if ($building->in_progress)
		@include('castle/counter')
	@endif

	@if ($properties['army'])
		@include('castle/army')
	@endif
</div>
