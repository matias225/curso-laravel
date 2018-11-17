@extends('layout')
@section('title', "Usuario {$user->id}")

@section('content')
    <h1>Usuario #{{$user->id}}</h1>
    <p>Mostrando detalle del usuario: {{$user->id}}</p>
    <p>Nombre del usuario: {{$user->name}}</p>
    <p>Correo electrónico: {{$user->email}}</p>

    <p>
        <a href={{ route('users') }}>Volver</a>
    </p>
@endsection
