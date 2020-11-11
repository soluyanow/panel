<?/*@yield('workarea')*/?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="/templates/default/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="/templates/default/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/templates/default/assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="/templates/default/assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="/templates/default/assets/css/colors.css" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="/templates/default/assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/plugins/loaders/blockui.min.js"></script>

        <script type="text/javascript" src="/templates/default/assets/js/plugins/visualization/d3/d3.min.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/plugins/forms/styling/switchery.min.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/plugins/pickers/daterangepicker.js"></script>

        <script type="text/javascript" src="/templates/default/assets/js/core/app.js"></script>
        <script type="text/javascript" src="/templates/default/assets/js/custom/custom.js"></script>

        <script type="text/javascript" src="/templates/default/assets/js/pages/dashboard.js"></script>
    </head>

    <body>
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">
                    <img src="/templates/default/assets/images/logo_light.png" alt="">
                </a>

                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Вход</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                                </li>
                            @endif
                        @else
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-user-plus"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="caret"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="#"><i class="icon-user-plus"></i>
                                        {{ Auth::user()->name }} </span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                        <i class="icon-switch2"></i>
                                        Выход
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        @endguest
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-container">
            <div class="page-content">
                <div class="sidebar sidebar-main">
                    <div class="sidebar-content">
                        <div class="sidebar-user">
                            <div class="category-content">
                                <div class="media">
                                    <div class="media-body">
                                        <ul class="navigation navigation-main navigation-accordion">
                                            <li><span class="media-heading text-semibold">Действия</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <ul class="navigation navigation-main navigation-accordion">
                                    @if (Request::path() == '/')
                                        <li class="active"><a href="/"><i class="icon-stack2"></i> <span>Резервные копии</span></a></li>
                                    @else
                                        <li><a href="/"><i class="icon-stack2"></i> <span>Резервные копии</span></a></li>
                                    @endif
                                    @if (Request::path() == 'clients')
                                        <li class="active">
                                            <a href="/clients/"><i class="icon-user-plus"></i> <span>Клиенты</span></a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="/clients/"><i class="icon-user-plus"></i> <span>Клиенты</span></a>
                                        </li>
                                    @endif
                                    @if (Request::path() == 'statuses')
                                        <li class="active">
                                            <a href="/statuses"><i class="icon-list-unordered"></i> <span>Статусы</span></a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="/statuses"><i class="icon-list-unordered"></i> <span>Статусы</span></a>
                                        </li>
                                    @endif

                                    @if (Request::path() == 'types')
                                        <li class="active">
                                            <a href="/types"><i class="icon-home4"></i> <span>Типы задач</span></a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="/types"><i class="icon-home4"></i> <span>Типы задач</span></a>
                                        </li>
                                    @endif

                                    @if (Request::path() == 'settings')
                                        <li class="active">
                                            <a href="/settings"><i class="icon-copy"></i> <span>Настройки</span></a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="/settings"><i class="icon-copy"></i> <span>Настройки</span></a>
                                        </li>
                                    @endif
                                    <li class="">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                            <i class="icon-switch2"></i>
                                            Выход
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">
                    <div class="page-header page-header-default">
                        @yield('head')
                        @yield('breadcrumb')
                    </div>

                    <div class="content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


