<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // Con Eloquent
        $users = User::all();
        
        //$users = DB::table('users')->get();

        $title = 'Listado de usuarios';

        // Tres formas de pasar los datos a la vista

        // Pasandole el array asociativo con las variables
        // return view('users', [
        //     'users' => $users,
        //     'title' => 'Listado de usuarios'
        // ]);

        // Pasandole las variables con with de a una en una
        // return view('users')
        // ->with('users', $users)
        // ->with('title', 'Listado de usuarios');

        // return view('users.index')
        // ->with('users', $users)
        // ->with('title', $title);

        // Utilizando compact, el cual devuelve un array asociativo
        return view('users.index', compact('title', 'users'));
    }

    public function show(User $user)
    {
        // $user = User::findOrFail($id);
        return view('users.show', compact('user'));
        //return "Mostrando detalle del usuario: {$id}";
    }

    public function create() {
        return view('users.create');
        // return 'Crear nuevo usuario';
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ''
        ]);

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('users.show', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
