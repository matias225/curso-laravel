@extends('layout')
@section('title',"Usuarios")

@section('content')
    <h1>{{ $title }}</h1>

    <ul>
        <p>Nombre (Correo Electrónico)</p>
        @forelse ($users as $user)
            <li>
                {{ $user->name }} ({{ $user->email }})
                <a href="{{ route('users.show', ['id' => $user->id]) }}">Ver detalles</a>
            </li>
        @empty
            <li>No hay usuarios registrados.</li>
        @endforelse
    </ul>
@endsection
