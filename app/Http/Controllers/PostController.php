<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show', 'index');
    }

    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);
        // se envía la información del modelo en un arreglo con key 'user' que toma el valor que viene del modelo
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => ['required', 'max:255'],
            'descripcion' => ['required'],
            'imagen' => ['required'],
        ]);

        // Se agregan los datos usando una instancia de modelo correspondiente a los Post
        // Post::create([
        //     'titulo'=>$request->titulo,
        //     'descripcion'=>$request->descripcion,
        //     'imagen'=>$request->imagen,
        //     'user_id'=>auth()->user()->id,
        // ]);

        // Otra forma
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;

        // Almacenando el post mediante una relación
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('post.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'user' => $user,
            'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        // Con authorize() se utilizan los métodos de los policies.
        $this->authorize('delete', $post);
        // Elimina el post
        $post->delete();

        //Elimina la imagen asociada al post
        // Genera la ruta de la imagen
        $imagen_path = public_path('uploads/' . $post->imagen);
        // Comprueba que la imagen existe
        if (File::exists($imagen_path)) {
            // Elimina la imagen del servidor
            unlink($imagen_path);
        }
        // Redirigimos al usuario de vuelta a su muro.
        return redirect()->route('post.index', auth()->user()->username);
    }
}
