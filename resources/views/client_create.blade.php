@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">Клиент создание</span>
            </h4>
        </div>
    </div>
@stop

@section('breadcrumb')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="index.html"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/clients/">Список клиентов</a></li>
            <li class="active">Клиент создание</li>
        </ul>
    </div>
@stop

@section('content')
    {{Form::open(['url' => '/clients/create', 'method' => 'POST'])}}
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-9">
                {{Form::open(['url' => '', 'method' => 'POST'])}}
                    <div class="row">
                        <fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Наименование</label>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" name="name" value="">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row">
                        <fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Периодичность обновления</label>
                                <div class="col-lg-1">
                                    <input type="text" class="form-control" name="period_update" value="">
                                </div>
                                <div class="col-lg-2">
                                    <select name="period_update_measure" class="form-control">
                                        <option value="#">Измерение</option>
                                        <option value="s">секунда</option>
                                        <option value="i">минута</option>
                                        <option value="h">час</option>
                                        <option value="d">день</option>
                                        <option value="m">месяц</option>
                                        <option value="y">год</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select name="period_update_type" class="form-control">
                                        <option value="#">Тип задачи обновления</option>
                                        @foreach ($types as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row">
                        <fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Периодичность выполнения</label>
                                <div class="col-lg-1">
                                    <input type="text" class="form-control" name="period_execute" value="">
                                </div>
                                <div class="col-lg-2">
                                    <select name="period_execute_measure" class="form-control">
                                        <option value="#">Измерение</option>
                                        <option value="s">секунда</option>
                                        <option value="i">минута</option>
                                        <option value="h">час</option>
                                        <option value="d">день</option>
                                        <option value="m">месяц</option>
                                        <option value="y">год</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select name="period_execute_type" class="form-control">
                                        <option value="#">Тип задачи выполнения</option>
                                        @foreach ($types as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row">
                        <fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Периодичность копирования</label>
                                <div class="col-lg-1">
                                    <input type="text" class="form-control" name="period_copy" value="">
                                </div>
                                <div class="col-lg-2">
                                    <select name="period_copy_measure" class="form-control">
                                        <option value="#">Измерение</option>
                                        <option value="s">секунда</option>
                                        <option value="i">минута</option>
                                        <option value="h">час</option>
                                        <option value="d">день</option>
                                        <option value="m">месяц</option>
                                        <option value="y">год</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select name="period_copy_type" class="form-control">
                                        <option value="#">Тип задачи копирования</option>
                                        @foreach ($types as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row">
                        <fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Активен</label>
                                <div class="col-lg-1">
                                    <input type="checkbox" id="client_active_field" class="form-control" name="active" value="true" style="height:18px">
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Сохранить
                    </button>
                {{Form::close()}}
            </div>
        </div>
    {{Form::close()}}

    <script>
        $('#client_active_field').on('change', function () {
            if ($('#client_active_field').prop('checked')) {
                $('#client_active_field').val('true');
            } else {
                $('#client_active_field').val('false');
            }
        })
    </script>
@stop

