<div class="my-castle">
	<a href="/castle"><img src="svg/city.svg" alt="Castle" class="world-castle castle-building-panel" data-tooltip-id="#castle-panel-{{$castle->name}}"></a>
</div>
<div class="castle-tooltip" id="castle-panel-{{$castle->name}}">
	<h5>{{$castle->name}}</h5>
	<a href="/castle" class="panel-button">Manage Castle</a>
</div>