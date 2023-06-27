@extends('abstract.index')

@section('title', 'Já')

@section('head')
    @parent
    @vite('resources/js/pages/user.tsx')
@endsection

@section('page_content')
    <bm-user-form></bm-user-form>
@endsection
