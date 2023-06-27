<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - {{ config('app.name') }}</title>

    @vite('resources/js/app.ts')
    @vite('resources/css/app.css')

    @yield('head', '')
</head>
<body>
@yield('body', '')
</body>
</html>
