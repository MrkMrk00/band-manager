@extends('abstract.base')

@php
    $redirectUrl = config('app.url').config('auth.facebook.redirect');

    $dialogUrl = sprintf('https://www.facebook.com/v17.0/dialog/oauth?client_id=%s&redirect_uri=%s&state=%s',
        config('auth.facebook.id'),
        htmlspecialchars($redirectUrl),
        csrf_token(),
    );
@endphp

@section('body')
    <main class="flex flex-col md:w-1/3 w-full h-full">
        <div class="flex flex-row justify-center py-4">
            <button id="fb-login-btn" class="btn bg-blue-400">Přihlásit se přes Facebook</button>
        </div>
    </main>

    <script defer type="text/javascript">
        function openFacebookLoginDialog() {
            const newWindow = window.open(
                '{!! $dialogUrl !!}',
                '_blank',
                'fullscreen=no,menubar=no,status=no,width=600,height=800',
            );

            if (newWindow) {
                newWindow.addEventListener('beforeunload', function () {
                    const url = new URL(location.href);
                    let toReplace = `${url.protocol}//${url.host}/`;

                    if (url.searchParams.get('next')) {
                        toReplace += url.searchParams.get('next');
                    }

                    location.replace(toReplace);
                });
            }
        }

        document.getElementById('fb-login-btn').addEventListener('click', openFacebookLoginDialog);
    </script>
@endsection
