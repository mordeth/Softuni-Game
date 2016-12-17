<div class="counter counter-label">
	Attacked by: {{$properties['battle']['defending']->attacker_name}} in <div data-countdown="{{date('Y/m/d H:i:s', strtotime($properties['battle']['defending']->end_time))}}"></div>
</div>