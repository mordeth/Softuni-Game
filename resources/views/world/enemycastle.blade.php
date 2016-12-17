<div class="enemy-castle">
	<img src="svg/fortress.svg" alt="Castle" class="world-castle castle-building-panel" data-tooltip-id="#castle-panel-{{$castle->name}}">
</div>
<div class="castle-tooltip" id="castle-panel-{{$castle->name}}">
	<h5>{{$castle->name}}</h5>
	<a href="/attack/{{$castle->id}}" class="panel-button">Attack Castle</a>
</div>