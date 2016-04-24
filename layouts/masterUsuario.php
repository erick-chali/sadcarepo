<!DOCTYPE html>
<html>
<head>
    <title>Repositorio - Usuario/@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-table.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/ripples.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/snackbar.min.css')}}">
    @yield('estilos')
</head>
<body>
<style>
    body {
        padding-top: 70px;
    }
    /* Rules for sizing the icon. */
    .material-icons.md-12 { font-size: 12px; }
    .material-icons.md-18 { font-size: 18px; }
    .material-icons.md-24 { font-size: 24px; }
    .material-icons.md-36 { font-size: 36px; }
    .material-icons.md-48 { font-size: 48px; }

    /* Rules for using icons as black on a light background. */
    .material-icons.md-dark { color: rgba(0, 0, 0, 0.54); }
    .material-icons.md-dark.md-inactive { color: rgba(0, 0, 0, 0.26); }

    /* Rules for using icons as white on a dark background. */
    .material-icons.md-light { color: rgba(255, 255, 255, 1); }
    .material-icons.md-light.md-inactive { color: rgba(255, 255, 255, 0.3); }
</style>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <a class="navbar-brand" href="{{URL::to('/usuario')}}">Usuario</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="material-icons">menu</i>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{URL::to('/usuario/create')}}">Crear</a></li>
                <li><a href="{{route('change', Auth::user()->codigo_usuario)}}">Cambiar mi contrase&ntilde;a</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="">Usuario: {{Auth::user()->nombre}}</a></li>
                <li><a href=""></a></li>
                <li><a href="/logout">Cerrar Sesi&oacute;n</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<div class="container">
    @yield('contenido')
</div>
</body>

<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-table.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/ripples.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/snackbar.min.js') }}"></script>
@yield('scripts')
</html>