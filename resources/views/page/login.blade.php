@extends('abstract.base')

@php
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Cache;

    $dialogUrl = null;
    if (App::environment('development') || !Cache::driver('file')->has('LoginPage__facebook-dialog')) {
        $redirectUrl = config('app.url').config('auth.facebook.redirect');

        $dialogUrl = sprintf('https://www.facebook.com/v17.0/dialog/oauth?client_id=%s&redirect_uri=%s&state=',
            config('auth.facebook.id'),
            htmlspecialchars($redirectUrl),
        );
    }
@endphp

@section('title', 'Přihlášení')

@push('head')
    <x-script cacheKey="LoginPage__facebook-dialog">
        function openFacebookLoginDialog() {
            const newWindow = window.open(
                '{!! $dialogUrl !!}' + Cookies.get('XSRF-TOKEN'),
                '_blank',
                'fullscreen=no,menubar=no,status=no,width=600,height=800',
            );

            if (newWindow) {
                newWindow.addEventListener('beforeunload', function() {
                    const url = new URL(location.href);
                    let toReplace = `${url.protocol}//${url.host}/`;

                    if (url.searchParams.get('next')) {
                        toReplace += url.searchParams.get('next');
                    }

                    location.replace(toReplace);
                });
            }
        }
    </x-script>
    @push('onready', "document.getElementById('fb-login-btn').addEventListener('click', openFacebookLoginDialog);")
@endpush


@section('body')
    <main class="flex flex-col md:w-1/3 w-full h-full">
        <div class="flex flex-row justify-center py-4">
            <button id="fb-login-btn" class="bm-btn bg-blue-400">Přihlásit se přes Facebook</button>
        </div>
    </main>
@endsection
