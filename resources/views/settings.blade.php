@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">Настройки</span>
            </h4>
        </div>
    </div>
@stop

@section('breadcrumb')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li class="active">Настройки</li>
        </ul>
    </div>
@stop

@section('content')
    {{Form::open(['url' => '/settings/update', 'method' => 'POST'])}}
        <?/*<legend class="text-bold">Basic inputs</legend>*/?>

        @forelse ($settings as $s => $setting)
            @if ($setting->name === 'debug_mode')
                <fieldset class="content-group">
                    <div class="form-group">
                        <label class="control-label col-lg-2">{{$setting->text}}</label>
                        <div class="col-lg-4">
                            @if ($setting->value == '1')
                                <input id="settings-check" type="checkbox" class="form-control" name="{{$setting->name}}" value="{{$setting->value}}" style="height: 18px" checked>
                            @else
                                <input id="settings-check" type="checkbox" class="form-control" name="{{$setting->name}}" value="{{$setting->value}}" style="height: 18px">
                            @endif
                        </div>
                    </div>
                </fieldset>
            @else
                <fieldset class="content-group">
                    <div class="form-group">
                        <label class="control-label col-lg-2">{{$setting->text}}</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="{{$setting->name}}" value="{{$setting->value}}">
                        </div>
                    </div>
                </fieldset>
            @endif
        @empty
            <div class="alert alert-primary" role="alert">
                Таблица настроек пустая
            </div>
        @endforelse

        <button type="submit" class="btn btn-primary bg-green-300">
            Сохранить
        </button>
    {{Form::close()}}
@stop
