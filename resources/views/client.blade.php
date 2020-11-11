@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">Клиент {{$client['name']['value']}}</span></h4>
        </div>
    </div>
@stop

@section('breadcrumb')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/clients/">Список клиентов</a></li>
            <li class="active">{{$client['name']['value']}}</li>
        </ul>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-9">
            {{Form::open(['url' => '/clients/update', 'method' => 'POST'])}}
                <div class="row">
                    <fieldset class="content-group" style="display: none;">
                        <div class="form-group">
                            <label class="control-label col-lg-3">{{$client['id']['text']}}</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="{{$client['id']['name']}}" value="{{$client['id']['value']}}">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label class="control-label col-lg-2">{{$client['name']['text']}}</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="{{$client['name']['name']}}" value="{{$client['name']['value']}}">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label class="control-label col-lg-2">{{$client['period_update']['text']}}</label>
                            <div class="col-lg-1">
                                <input type="text" class="form-control" name="{{$client['period_update']['name']}}" value="{{$client['period_update']['value']}}">
                            </div>
                            <div class="col-lg-2">
                                <select name="{{$client['period_update_measure']['name']}}" class="form-control">
                                    <option value="#">Измерение</option>
                                    @foreach ($client['select'] as $s => $select)
                                        @if ($client['period_update_measure']['value'] == $s)
                                            <option value="{{$s}}" selected>{{$select}}</option>
                                        @else
                                            <option value="{{$s}}">{{$select}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select name="{{$client['period_update_type']['name']}}" class="form-control">
                                    <option value="#">Измерение</option>
                                    @foreach ($types as $type)
                                        @if ($type['id'] == $client['period_update_type']['value'])
                                            <option value="{{$type['id']}}" selected>{{$type['name']}}</option>
                                        @else
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label class="control-label col-lg-2">{{$client['period_execute']['text']}}</label>
                            <div class="col-lg-1">
                                <input type="text" class="form-control" name="{{$client['period_execute']['name']}}" value="{{$client['period_execute']['value']}}">
                            </div>
                            <div class="col-lg-2">
                                <select name="{{$client['period_execute_measure']['name']}}" class="form-control">
                                    <option value="#">Измерение</option>
                                    @foreach ($client['select'] as $s => $select)
                                        @if ($client['period_execute_measure']['value'] == $s)
                                            <option value="{{$s}}" selected>{{$select}}</option>
                                        @else
                                            <option value="{{$s}}">{{$select}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select name="{{$client['period_execute_type']['name']}}" class="form-control">
                                    <option value="#">Измерение</option>
                                    @foreach ($types as $type)
                                        @if ($type['id'] == $client['period_execute_type']['value'])
                                            <option value="{{$type['id']}}" selected>{{$type['name']}}</option>
                                        @else
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label class="control-label col-lg-2">{{$client['period_copy']['text']}}</label>
                            <div class="col-lg-1">
                                <input type="text" class="form-control" name="{{$client['period_copy']['name']}}" value="{{$client['period_copy']['value']}}">
                            </div>
                            <div class="col-lg-2">
                                <select name="{{$client['period_copy_measure']['name']}}" class="form-control">
                                    <option value="#">Измерение</option>
                                    @foreach ($client['select'] as $s => $select)
                                        @if ($client['period_copy_measure']['value'] == $s)
                                            <option value="{{$s}}" selected>{{$select}}</option>
                                        @else
                                            <option value="{{$s}}">{{$select}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select name="{{$client['period_copy_type']['name']}}" class="form-control">
                                    <option value="#">Измерение</option>
                                    @foreach ($types as $type)
                                        @if ($type['id'] == $client['period_copy_type']['value'])
                                            <option value="{{$type['id']}}" selected>{{$type['name']}}</option>
                                        @else
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label class="control-label col-lg-2">{{$client['active']['text']}}</label>
                            <div class="col-lg-1">
                                @if ($client['active']['value'])
                                    <input type="checkbox" class="form-control" name="{{$client['active']['name']}}" value="{{$client['active']['value']}}" style="height:18px" checked>
                                @else
                                    <input type="checkbox" class="form-control" name="{{$client['active']['name']}}" value="{{$client['active']['value']}}" style="height:18px">
                                @endif
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
@stop
