@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">Список клиентов</span>
            </h4>
        </div>
    </div>
@stop

@section('breadcrumb')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li class="active">Список клиентов</li>
        </ul>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-flat">
                {{Form::open(['url' => '/clients/new/', 'method' => 'GET'])}}
                    <div class="table-responsive">
                        <table class="table table-lg text-nowrap">
                            <tbody>
                                <tr>
                                    <td class="text-left col-md-2">
                                        <button type="submit" class="btn bg-success-300">
                                            <i class="icon-new position-left"></i>
                                            Создать
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                {{Form::close()}}

                @if (!empty($clients['clients']))
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Клиент</th>
                                    <th class="col-md-2">Частота обновления</th>
                                    <th class="col-md-2">Частота выполнения</th>
                                    <th class="col-md-2">Частота копирования</th>
                                    <th class="col-md-2">Статус</th>
                                    <th class="text-center" style="width: 20px;"></th>
                                </tr>
                            </thead>

                            @foreach ($clients['clients'] as $client)
                                <tr>
                                    <td>
                                        <div class="media-left media-middle">
                                            <a href="#"><img src="assets/images/brands/facebook.png" class="img-circle img-xs" alt=""></a>
                                        </div>
                                        <div class="media-left">
                                            <div class=""><a href="#" class="text-default text-semibold">{{$client['name']}}</a></div>
                                        </div>
                                    </td>
                                    <td class="text-left">{{$client['period_update']}} {{$clients['fields'][$client['period_update_measure']]}}</td>
                                    <td class="text-left">{{$client['period_execute']}} {{$clients['fields'][$client['period_execute_measure']]}}</td>
                                    <td class="text-left">{{$client['period_copy']}} {{$clients['fields'][$client['period_copy_measure']]}}</td>
                                    @if ($client['active'] === 1)
                                        <td><span class="label bg-blue">Активен</span></td>
                                    @else
                                        <td><span class="label bg-brown">Не активен</span></td>
                                    @endif

                                    <td class="text-left">
                                        <div class="media-left media-middle">
                                            <a href="{{route('clients.show', $client['id'])}}" style="margin-right:10px"><i class="icon-pencil"></i></a>
                                            <a href="/clients/delete/{{$client['id']}}"><i class="icon-database-remove"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        Отсутствуют клиенты
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
