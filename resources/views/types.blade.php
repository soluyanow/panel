@extends('layouts.main')

@section('head')
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">Типы</span>
            </h4>
        </div>
    </div>
@stop

@section('breadcrumb')
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li class="active">Типы</li>
        </ul>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-flat">
                {{Form::open(['url' => '/types/new', 'method' => 'GET'])}}
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

                @if ($types)
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                            <tr>
                                <th>Статус</th>
                                <th class="text-center" style="width: 20px;"></th>
                            </tr>
                            </thead>

                            @foreach ($types as $type)
                                <tr>
                                    <td>
                                        <div class="media-left media-middle">
                                            <a href="#"><img src="assets/images/brands/facebook.png" class="img-circle img-xs" alt=""></a>
                                        </div>
                                        <div class="media-left">
                                            <div class=""><a href="#" class="text-default text-semibold">{{$type['name']}}</a></div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div class="media-left media-middle">
                                            <a href="/types/show/{{$type['id']}}" style="margin-right:10px;"><i class="icon-pencil"></i></a>
                                            <a href="/types/delete/{{$type['id']}}"><i class="icon-database-remove"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        Таблица типов пустая
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
