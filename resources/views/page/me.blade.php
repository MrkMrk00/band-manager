@extends('abstract.index')

@php
    /** @var \BandManager\App\Models\User $user */
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp

@section('title', 'Já')

@section('page_content--classes', 'pt-4')

@section('page_content')
    <form class="flex flex-col border max-w-xl rounded-2xl mx-2 sm:mx-auto shadow" action="/me" method="post">
        @csrf
        <x-me.form-row class="rounded-t-2xl border-b bg-slate-50">
            <h2 class="font-bold text-xl">Já</h2>
        </x-me.form-row>
        <x-me.form-row key="display_name" label="Přezdívka" :value="$user->display_name"></x-me.form-row>
        <x-me.form-row label="Zdroj přihlášení">
            @if($user->fb_id !== null)
                <div class="flex flex-row gap-2 items-center">
                    <x-icon type="brands" name="facebook" height="2.5em" path-class="fill-[#1877f2]" />
                    <span>Facebook</span>
                </div>
            @endif
        </x-me.form-row>
        <x-me.form-row class="justify-end border-t">
            <button type="submit" class="bm-btn bg-green-400">Uložit změny</button>
        </x-me.form-row>
    </form>
@endsection
