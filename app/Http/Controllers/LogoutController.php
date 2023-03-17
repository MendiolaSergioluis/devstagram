<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store()
    {
        // Cierre de sesión
        auth()->logout(); 

        // Redirección hacia página de login
        return redirect()->route('login');
    }
}
