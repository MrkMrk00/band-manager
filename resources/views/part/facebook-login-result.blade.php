@extends('abstract.base')

@section('body')
    @if(!empty($success))
        <script type="text/javascript">
            window.close();
        </script>
    @else
        <main class="flex flex-row justify-center items-center w-full h-full">
            <span>
                {{ $reason ?? 'Něco se nepovedlo :(' }}
            </span>
        </main>
    @endif
@endsection
