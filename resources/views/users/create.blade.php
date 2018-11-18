@extends('layout')
@section('title', 'Crear usuario')

@section('content')
    <h1>Crear Usuario</h1>
    <div>
        <form method="POST" action="{{url('usuarios')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="name">Nombre</label>
                <input class="form-control" type="text" name="name" id="name" placeholder="Matias Romani" required>
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="matias@example.com" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="6 o más caracteres" required>
            </div>
            <button class="btn btn-success" type="submit">Crear usuario</button>
        </form>
    </div>
    <br>
    <div>
        <a class="btn btn-primary" href={{ route('users') }}>Volver</a>
    </div>
@endsection