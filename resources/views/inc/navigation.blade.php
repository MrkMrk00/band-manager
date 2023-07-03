@php
    use Illuminate\Support\Facades\Request;

    /** @var \BandManager\App\Models\User $user */
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp

@section('after_body')
    @parent
    @vite('resources/js/menu.ts')
@endsection

<nav id="bm-desktop-navigation" class="bm-navbar">
    <div class="flex flex-row gap-4">
        <div class="non-mobile">
            <a href="/">
                <h1 class="font-bold text-2xl py-4">{{ config('app.name') }}</h1>
            </a>
        </div>
        <div class="flex flex-row gap-2 items-center">
            <a @class(['nav-link', 'active' => Request::is('/') ]) href="/">
                Domů
            </a>
            <a @class(['nav-link', 'active' => Request::is('other', 'other/**') ]) href="/other">
                Other
            </a>
        </div>
    </div>
    <div>
        <a @class([
            'flex', 'flex-row', 'justify-end', 'items-center', 'gap-2', 'h-full', 'nav-link',
            'active' => Request::is('me', 'me/**'),
        ]) href="/me">
            <x-icon name="circle-user" height="24px" class="nav-user-icon" />
            <span>{{ str_truncate($user->getShortName()) }}</span>
        </a>
    </div>
</nav>
