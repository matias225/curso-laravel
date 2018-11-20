@extends('layout')
@section('title', "Usuario {$user->id}")

@section('content')
    <div class="card">
        <h4 class="card-header">Usuario #{{$user->id}}</h4>
        <div class="card-body">
            <p>Mostrando detalle del usuario: {{$user->id}}</p>
            <p>Nombre del usuario: {{$user->name}}</p>
            <p>Correo electrónico: {{$user->email}}</p>
            <p>
                <a class="btn btn-primary" href={{ route('users.index') }}>Volver</a>
            </p>
        </div>
    </div>
@endsection
