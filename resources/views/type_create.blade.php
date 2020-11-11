@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">Тип задачи создание</span>
            </h4>
        </div>
    </div>
@stop

@section('breadcrumb')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/types/">Список типов задач</a></li>
            <li class="active">Тип задачи создание</li>
        </ul>
    </div>
@stop

@section('content')
    {{Form::open(['url' => '/types/create', 'method' => 'POST'])}}
        <fieldset class="content-group">
            <div class="form-group">
                <label class="control-label col-lg-2">Имя</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="name" value="">
                </div>
            </div>
        </fieldset>

        <button type="submit" class="btn bg-success-300">
            Создать
        </button>
    {{Form::close()}}
@stop

