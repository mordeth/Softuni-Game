@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <table class="world-map">
                    @for ($y = 1; $y < 8; $y++)
                        <tr>
                            @for ($x = 1; $x < 11; $x++)
                                <td>
                                    @foreach ($castles as $castle)
                                        @if ($castle->location_x === $x && $castle->location_y === $y)
                                            @include('world/castle')
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
</div>
@endsection
