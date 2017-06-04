@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Reservas</div>

                <div class="panel-body">
                    <div class="form-group col-md-4">
                        <div class='input-group date datepicker' name="datepicker" >
                             <input type='text' class="form-control placementT" id="fecha">
                             <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                             </span>
                        </div>
                    </div>
                    <div class="table-responsive col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sala</th>
                                    @for ($i = 0; $i < 24; $i++)
                                        <th>{{ $i . ':00' }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                            <th>Sala</th>
                                @for ($i = 0; $i < 24; $i++)
                                    <td>
                                        Livre
                                        <br>
                                        <a href="#" class="btn btn-sm btn-success">Reservar</a>
                                    </td>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
