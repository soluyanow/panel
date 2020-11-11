@extends('layouts.main')

@section('content')
    {{Form::open(['url' => '/clients/', 'method' => 'GET'])}}
        <div class="alert alert-warning" role="alert">
            Произошла ошибка
        </div>

        <div class="alert alert-warning" role="alert">
            <?//print_r(debug_backtrace())?>

        </div>

        <button type="submit" class="btn btn-primary">
            Назад
        </button>
    {{Form::close()}}
@stop
