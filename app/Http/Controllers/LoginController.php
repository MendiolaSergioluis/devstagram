<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);


        // Si el usuario no puede ser autenticado mediante 'email' y 'password':
        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
            // Con back() se retorna a la pagina de autenticación
            // Y with() genera un mensaje de error el cual va a ser 
            // enviado al usuario si la autenticación falla. 
        }

        // Envía al usuario a su post en caso de que las credenciales sean correctas
        return redirect()->route('post.index', auth()->user());
    }
}
