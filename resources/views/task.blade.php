@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                @if (empty($task['clients_id']))
                    <span class="text-semibold">Результат задачи клиента</span>
                @else
                    <span class="text-semibold">Результат задачи клиента {{$task['clients_id']}}</span>
                @endif
            </h4>
        </div>
    </div>
@stop

@section('menu')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ul>

        <ul class="breadcrumb-elements">
            <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-gear position-left"></i>
                    Settings
                    <span class="caret"></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
                    <li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
                    <li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-gear"></i> All settings</a></li>
                </ul>
            </li>
        </ul>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if (empty($task))
                <div class="alert alert-primary" role="alert">
                    Отсутствиет информация о результате бэкапа
                </div>
            @else
                {{print_r($task['source'])}}
            @endif
        </div>
    </div>
@stop
