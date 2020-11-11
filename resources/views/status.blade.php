@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">Статус {{$status['id']}}</span>
            </h4>
        </div>
    </div>
@stop

@section('breadcrumb')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/statuses/">Статусы</a></li>
            <li class="active">{{$status['id']}}</li>
        </ul>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-flat" style="box-sizing: border-box;padding: 10px">
                @if ($status)
                    {{Form::open(['url' => '/statuses/update', 'method' => 'POST'])}}
                        @foreach ($status as $i => $item)
                            @if ($i == 'id')
                                <fieldset class="content-group" style="display:none">
                            @elseif ($i == 'updated_at')
                                <fieldset class="content-group" style="display:none">
                            @elseif ($i == 'created_at')
                                <fieldset class="content-group" style="display:none">
                            @else
                                <fieldset class="content-group">
                            @endif
                                    <div class="form-group">
                                        @if ($i == 'name')
                                            <label class="control-label col-lg-3">Текст статуса</label>
                                        @elseif ($i == 'identity')
                                            <label class="control-label col-lg-3">Идентификатор</label>
                                        @endif
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="{{$i}}" value="{{$item}}">
                                        </div>
                                    </div>
                                </fieldset>
                        @endforeach
                        <button type="submit" class="btn btn-primary btn-block">
                            Сохранить
                        </button>
                    {{Form::close()}}
                @else
                    <div class="alert alert-warning" role="alert">
                        Запись статуса пустая
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
