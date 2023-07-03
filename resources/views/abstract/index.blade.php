@extends('abstract.base')

@php
    $user = \Illuminate\Support\Facades\Auth::user();
    $userJson = json_encode($user);
@endphp

@push('head')
    <x-script cacheKey="IndexAbstractTpl__js-global-props-pass">
        window.BandManager = {
            User: {!! $userJson !!},
        };
    </x-script>
@endpush

@section('body')
    @include('inc.navigation')
    <main id="page_content" class="transition-fade @yield('page_content--classes', '')">
        @yield('page_content', '')
    </main>
@endsection
