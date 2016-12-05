@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <table class="world-map">
                    @for ($t = 0; $t < 10; $t++)
                        <tr>
                            @for ($x = 0; $x < 10; $x++)
                                <td><!-- List castle in each cell --></td>
                            @endfor
                        </tr>

                        </p>
                    @endfor
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
