@extends('abstract.base')

@php
    $user = \Illuminate\Support\Facades\Auth::user();
    $userJson = json_encode($user);
@endphp

@section('head')
    @parent
    <script type="text/javascript">
        window.BandManager = {
            User: {!! $userJson !!},
        };
    </script>
@endsection

@section('body')
    @include('inc.navigation')
    <main id="page_content" class="transition-fade">
        @yield('page_content', '')
    </main>
@endsection
