@extends('abstract.base')

@section('body')
    @if(!empty($success))
        huehuehuehfiausfgika
    @else
        <main class="flex flex-row justify-center items-center w-full h-full">
            <span>
                {{ $reason ?? 'Něco se nepovedlo :(' }}
            </span>
        </main>
    @endif
@endsection
