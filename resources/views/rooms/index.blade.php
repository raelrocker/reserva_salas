@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
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
                    <div class="panel-heading">Salas</div>
                    <div class="panel-body">
                        <a href="/salas/cadastrar" class="btn btn-primary">Cadastrar Sala</a>
                        <br><br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <th scope="row">{{ $room->id }}</th>
                                    <td>{{ $room->name }}</td>
                                    <td>
                                        <a href="/salas/editar/{{ $room->id }}"
                                           class="btn btn-sm btn-success">Editar</a>
                                        <form action="{{ URL::route('rooms.destroy',$room->id) }}" method="POST" style="display: inline-block">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Tem certeza?')">Remover</button>
                                        </form>
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
@endsection