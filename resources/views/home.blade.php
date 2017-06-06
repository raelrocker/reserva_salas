@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    <h2>{{ Session::get('success') }}</h2>
                </div>
            @endif
            @if(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    <h2>{{ Session::get('fail') }}</h2>
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Reservas</div>

                <div class="panel-body">

                        <div class="form-group col-md-4">
                            <div class='input-group date datepicker' name="datepicker" >

                                <input type='text' class="form-control placementT" id="fecha" name="date">
                                <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                </span>

                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" class="btn btn-primary"
                                    onclick="location.href = '/home/' + getDate(document.getElementById('fecha').value)">Ir</button>
                        </div>
                        <div class="col-md-12">
                            <?php
                                $date = \Carbon\Carbon::parse($date);
                            ?>
                            <h3>{{ $date->format('d/m/Y') }}</h3>
                        </div>
                        <div class="form-group col-md-12">
                            <br>
                            <div>
                                Legenda:
                                <span class="btn btn-sm btn-default">Livre</span>
                                <span class="btn btn-sm btn-warning">Reservados</span>
                                <span class="btn btn-sm btn-danger">Reservados por você</span>
                            </div>
                        </div>

                    <div class="table-responsive col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sala</th>
                                    <th>Reservas</th>
                                    <th>Livre</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <th>{{ $room->name }}</th>
                                    <td>
                                        @foreach($reserves[$room->id] as $reserve)
                                            <?php
                                                $date = \Carbon\Carbon::parse($reserve->datetime);
                                                $reservedByUser = ( Auth::user()->id == $reserve->user_id);
                                            ?>
                                            @if ($reservedByUser)
                                                <form action="{{ URL::route('reserves.destroy',$reserve->id) }}" method="POST" style="display: inline-block">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button class="btn btn-sm btn-danger" style="margin-bottom: 2px" onclick="return confirm('Tem certeza?')">
                                                        {{ $date->format('H'). ':00' }}
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </button>
                                                </form>

                                            @else
                                                <a href="javascript:void(0)" class="btn btn-sm btn-warning"  style="margin-bottom: 2px">
                                                    {{ $date->format('H'). ':00' }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($free[$room->id] as $reserve)
                                            <form action="{{ URL::route('reserves.store') }}" method="POST" style="display: inline-block">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                                <input type="hidden" name="datetime" value="{{ $date->format('Y-m-d') . ' ' . $reserve . ':00'  }}">
                                                <button class="btn btn-sm btn-default" style="margin-bottom: 2px" title="Reservar">
                                                    {{ $reserve }}
                                                    <span class="glyphicon glyphicon-star"></span>
                                                </button>
                                            </form>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
