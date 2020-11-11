@extends('layouts.main')

@section('content')
    {{Form::open(['url' => '/settings/', 'method' => 'GET'])}}
        <div class="alert alert-success" role="alert">
            Успешно
        </div>

        <button type="submit" class="btn btn-primary">
            Назад
        </button>
    {{Form::close()}}
@stop
