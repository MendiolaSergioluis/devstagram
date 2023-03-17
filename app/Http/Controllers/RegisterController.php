<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User; // Se agregó el Modelo User
use Illuminate\Support\Facades\Hash; // Se agregó para Hashear los passwords

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        // Validación
        $this->validate($request,[
            'name' => ['required','max:20'],
            'username' => ['required', 'unique:users', 'min:3', 'max:20'],
            'email' => ['required', 'unique:users', 'email', 'max:60'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        // Crear registro en la base de datos
        // se utiliza el método estático 'create' del modelo 'User'
        User::create([
            'name' => $request->name,
            'username' => $request->username, // Ya el request viene modificado como slug
            'email' => $request->email,
            'password' => Hash::make( $request->password ) // Hashea el password
             ]);


        // Autenticar un usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        // Otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));

        // Redireccionar
        return redirect()->route('post.index', auth()->user());
    }
}
