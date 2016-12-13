<div class="castle">
	@if ($castle->user_id === $logged_user)
		@include('world/mycastle')
	@else
		@include('world/enemycastle')
	@endif
</div>
