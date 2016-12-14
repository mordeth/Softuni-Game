<div class="castle">
    @if ($building->building_level > 0)
        <img src="/svg/{{$building->type}}.svg" alt="{{$building->name}}}">
    @else:
        <img src="/svg/{{$building->type}}_outline.svg" alt="{{$building->name}}}">
    @endif;
</div>
