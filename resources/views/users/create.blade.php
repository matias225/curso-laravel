@extends('layout')
@section('title', 'Crear usuario')

@section('content')
    <h1>Crear Usuario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h6>Por favor corrige los siguientes errores debajo:</h6>
            {{--<ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>--}}
        </div>
    @endif

    <div>
        <form method="POST" action="{{url('usuarios')}}">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="name">Nombre</label>
                <input class="form-control" type="text" name="name" id="name" placeholder="Matias Romani" value="{{ old('name') }}">
            </div>
            @if ($errors->has('name'))
                <p>{{ $errors->first('name') }}</p>
            @endif

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="matias@example.com" value="{{ old('email') }}">
            </div>
            @if ($errors->has('email'))
                <p>{{ $errors->first('email') }}</p>
            @endif

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="6 o más caracteres" >
            </div>
            @if ($errors->has('password'))
                <p>{{ $errors->first('password') }}</p>
            @endif

            <button class="btn btn-success" type="submit">Crear usuario</button>
        </form>
    </div>
    <br>
    <div>
        <a class="btn btn-primary" href={{ route('users') }}>Volver</a>
    </div>
@endsection