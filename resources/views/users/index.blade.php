@extends('layout')
@section('title',"Usuarios")

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-2">
        <h1 class="pb-1">{{ $title }}</h1>
        <p>
            <a class="btn btn-primary" href="{{ route('users.create') }}"><span class="oi oi-plus"></span> Nuevo Usuario</a>
        </p>
    </div>

    @if($users->isNotEmpty())
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Corre Electrónico</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('users.destroy', $user) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <a class="btn btn-success" href="{{ route('users.show', $user) }}"><span class="oi oi-eye"></span></a>
                    <a class="btn btn-primary" href="{{ route('users.edit', $user) }}"><span class="oi oi-pencil"></span></a>
                    <button class="btn btn-danger" type="submit"><span class="oi oi-trash"></span></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <p>No hay usuarios registrados.</p>
    @endif
@endsection
