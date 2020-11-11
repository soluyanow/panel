@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">Тип {{$type['id']}}</span>
            </h4>
        </div>
    </div>
@stop

@section('breadcrumb')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/types/">Типы</a></li>
            <li class="active">{{$type['id']}}</li>
        </ul>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-flat" style="box-sizing: border-box;padding: 10px">
                @if ($type)
                    {{Form::open(['url' => '/types/update', 'method' => 'POST'])}}
                        <fieldset class="content-group" style="display: none">
                            <div class="form-group">
                                <label class="control-label col-lg-2">id</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="id" value="{{$type['id']}}">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Имя</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="name" value="{{$type['name']}}">
                                </div>
                            </div>
                        </fieldset>

                        <button type="submit" class="btn btn-primary btn-block">
                            Сохранить
                        </button>
                    {{Form::close()}}
                @else
                    <div class="alert alert-warning" role="alert">
                        Запись типа пустая
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
