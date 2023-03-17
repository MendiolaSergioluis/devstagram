<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowerController extends Controller
{
    // Método para seguir
    public function store(User $user)
    {
        // Se utiliza el método attach y no create ya que esta tabla hace referencia al propio usuario.
        $user->followers()->attach(auth()->user()->id);
        return back();
    }

    // Método para dejar de seguir
    public function destroy(User $user)
    {
        $user->followers()->detach(auth()->user()->id);
        return back();
    }
}
