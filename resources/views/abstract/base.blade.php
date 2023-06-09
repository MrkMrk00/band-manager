<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - {{ config('app.name') }}</title>

    @vite('resources/js/app.ts')
    @vite('resources/css/app.css')

    @stack('head')
</head>
<body>
@yield('body', '')
@yield('after_body', '')
<script type="text/javascript">document.addEventListener('DOMContentLoaded',()=>{@stack('onready')});</script>
</body>
</html>
