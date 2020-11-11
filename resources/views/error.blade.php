@extends('layouts.main')

@section('content')
    {{Form::open(['url' => '/', 'method' => 'GET'])}}
        <div class="alert alert-warning" role="alert">
            Произошла ошибка
        </div>

        @if (!empty($debug))
            <div class="alert alert-warning" role="alert">
                <span class="text-semibold">Debug backtrace</span>
                <hr>

                @foreach ($debug as $e => $error)
                    <div class="errors">
                        <div>
                            <span>[{{$e}}] - </span>
                            <span>{</span>
                            <div>
                                <span>&nbsp;&nbsp;[file] - {{$error['file']}}</span><br>
                                <span>&nbsp;&nbsp;[line] - {{$error['line']}}</span><br>
                                <span>&nbsp;&nbsp;[function] - {{$error['function']}}</span><br>
                                <span>&nbsp;&nbsp;[class] - {{$error['class']}}</span><br>
                                <span>&nbsp;&nbsp;[type] - {{$error['type']}}</span><br>
                                <span>&nbsp;&nbsp;[object] - {{$error['object']}}</span><br>
                                <span>&nbsp;&nbsp;[args] - {{$error['args']}}</span><br>
                            </div>
                            <span>};</span>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

        <button type="submit" class="btn btn-primary">
            Назад
        </button>
    {{Form::close()}}
@stop

