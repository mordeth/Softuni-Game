@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <table class="castle-map">
                @for ($y = 1; $y < 6; $y++)
                    <tr>
                        @for ($x = 1; $x < 6; $x++)
                            <td>
                                @foreach ($buildings as $building)
                                    @if ($building->position_x === $x && $building->position_y === $y)
                                        @include('castle/building')
                                    @endif
                                @endforeach
                            </td>
                        @endfor
                    </tr>
                @endfor
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
