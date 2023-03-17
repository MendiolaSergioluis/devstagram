<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Hace que solo lo usuarios logueados puedan ingresar a la página principal.
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke()
    {
        //Obtener a quienes seguimos
        $ids = auth()->user()->following->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

        // Toma todos los 'id' de usuarios registrados
        $allPosts = User::all()->pluck('id')->toArray();
        // Genera la diferencia entre los usuarios seguidos y el total de usuarios
        $diff_1 = array_diff($ids, $allPosts);
        $diff_2 = array_diff($allPosts, $ids);
        $mergeDiff = array_merge($diff_1, $diff_2);

        // Genera un array con los posts de los usuarios que no estamos siguiendo.
        $more_posts = Post::whereIn('user_id', $mergeDiff)->latest()->paginate(20);



        return view('home',[
            // Envía los posts de los usuarios a los que seguimos.
            'posts'=> $posts,
            // Envía los posts del resto de usuarios que no seguimos.
            'more_posts' => $more_posts
        ]);
    }
}
