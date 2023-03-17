@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto flex flex-col md:flex-row gap-10">
        <div class="md:w-1/2 px-6 justify-center">
            <!-- Caja de Post -->
            <img class="rounded-xl mx-auto" src="{{ asset('uploads') . '/' . $post->imagen }}"
                alt="Imagen del post {{ $post->titulo }}">
            <div class="p-3 flex items-center gap-4">
                @auth
                <livewire:like-post :post="$post"/>
                @endauth
            </div>
            <div class="font-bold">
                <a class="font-bold uppercase" href="{{ route('post.index', $post->user) }}">
                <p>{{ $post->user->username }}</p>
                </a>
                <p class="text-sm text-gray-500">
                    <!-- diffForHumans() muestra la diferencia de tiempo desde la fecha de publicación hasta la fecha actual de la forma en que acostumbramos a verla -->
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
            <p>{{ $post->descripcion }}</p>

            @auth
                @if ($post->user_id === auth()->user()->id)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Eliminar Publicación"
                            class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer">
                    </form>
                @endif

            @endauth

        </div>

        <div class="md:w-1/2 px-5">
            <!-- Caja de Comentarios -->
            @auth
                <div class="shadow bg-white p-5 mb-5">
                    <p class="text-xl font-bold text-center mb-4">Agregar un Nuevo Comentario</p>

                    @if (session('mensaje'))
                        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                                Comentario
                            </label>
                            <textarea id="comentario" name="comentario" placeholder="Agrega tu comentario"
                                class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror"></textarea>
                            @error('comentario')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="submit" value="Comentar"
                            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
                    </form>
                </div>
            @endauth
            <div class="shadow bg-white p-5 mb-5">
                <p class="text-xl font-bold text-center mb-4">Comentarios</p>
                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div class="p-5 border-gray-300 border-b m-6 shadow-lg">
                                <a class="font-bold uppercase" href="{{ route('post.index', $comentario->user) }}">
                                    {{ $comentario->user->username }}:
                                </a>
                                <p>{{ $comentario->comentario }}</p>
                                <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No hay comentarios aún</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
