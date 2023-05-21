@extends('layouts.dashboard')

@section('title', 'Correo de Buenos Aires | Dashboard')

@section('header')
    <header>
        @include('components.aside-nav')
    </header>
@endsection

@section('content')
    <h2 class="text-xl md:text-2xl">Bienvenido {{$user->name}} {{$user->last_name}}</h2>
@endsection
