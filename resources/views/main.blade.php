<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ペット健康管理') }}</title>

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-200">
<div id="app" style="max-width:640px; margin: 0 auto;">
    <header-component></header-component>
    <router-view></router-view>
</div>
<!-- Scripts -->
<script src="{{ mix('/js/app.js') }}" defer></script>
{{-- <script src="{{ asset('./js/bootstrap.js') }}" defer></script> --}}
</body>
</html>