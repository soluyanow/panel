@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">Резервные копии</span>
            </h4>
        </div>
    </div>
@stop

@section('breadcrumb')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li class="active">Резервные копии</li>
        </ul>
    </div>
@stop

@section('content')
    <!-- Tasks options -->
    <div class="navbar navbar-default navbar-xs navbar-component">
        <ul class="nav navbar-nav no-border visible-xs-block">
            <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
        </ul>

        <div class="navbar-collapse collapse" id="navbar-filter">
            <p class="navbar-text">Фильтр:</p>
            {{Form::open(['url' => '/tasks', 'method' => 'GET'])}}
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-sort-amount-desc position-left"></i> По типу <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?type=all">Отображать все</a></li>
                            <li class="divider"></li>
                            @foreach ($filters['types'] as $type)
                                <li><a href="?type={{$type['id']}}">{{$type['name']}}</a></li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-sort-numeric-asc position-left"></i> По статусу <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?status=all">Отображать все</a></li>
                            <li class="divider"></li>
                            @foreach ($filters['statuses'] as $status)
                                <li><a href="?status={{$status['id']}}">{{$status['name']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            {{Form::close()}}
        </div>
    </div>
    <!-- /tasks options -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-flat">
                <div class="table-responsive">
                    <table class="table table-lg text-nowrap">
                        <tbody>
                        <tr>
                            <td class="text-left col-md-2">
                                <a id="import-issues" href="#" class="btn bg-blue-300"><i class="icon-import position-left"></i> Импорт</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @if ($tasks)
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Клиент</th>
                                    <th class="col-md-2">Статус</th>
                                    <th class="text-center" style="width: 100px;"></th>
                                </tr>
                            </thead>

                            @foreach ($tasks as $task)
                                <tr>
                                    <td>
                                        <div class="media-left media-middle">
                                            <a href="#"><img src="assets/images/brands/facebook.png" class="img-circle img-xs" alt=""></a>
                                        </div>
                                        <div class="media-left">
                                            <div class=""><a href="#" class="text-default text-semibold">{{$task['client']['name']}}</a></div>
                                            <div class="text-muted text-size-small">
                                                <span class="status-mark border-blue position-left"></span>
                                                {{$task['updated_at']}}
                                            </div>
                                        </div>
                                    </td>

                                    <td><span class="label {{$task['status']['identity']}}">{{$task['status']['name']}}</span></td>
                                    <td class="text-left">
                                        <div class="media-left media-middle">
                                            <a href="{{route('tasks.show', $task['id'])}}" style="margin-right:10px"><i class="icon-pencil"></i></a>
                                            <a href="/tasks/delete/{{$task['id']}}"><i class="icon-database-remove"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="alert alert-primary" role="alert">
                        Список задач пуст
                    </div>
                @endif
            </div>
        </div>
    </div>

@stop
