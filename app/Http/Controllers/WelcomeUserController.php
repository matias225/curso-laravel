<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUserController extends Controller
{
    public function welcome() {
        return view('welcome');
    }

    public function greetingWithNickname($name, $nickname) {
        $name = ucfirst($name);
        return "Bienvenido {$name}, tu apodo es {$nickname}";
    }

    public function greetingWithoutNickname($name) {
        $name = ucfirst($name);
        return "Bienvenido {$name}";
    }
}
