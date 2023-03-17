@extends('layouts.app')

@section('titulo')
    Página Principal
@endsection

@section('contenido')
    @if ($posts->count())
        <!-- Se muestran primero los posts de los usuarios que seguimos -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 justify-center">
            <x-listar-post :posts='$posts'/>
            <!-- Después se muestran los posts de los usuarios de la plataforma -->
            <x-listar-post :posts='$more_posts'/>
        </div>
    @else
        <!-- Muestran los posts de los usuarios de la plataforma -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 justify-center">
            <x-listar-post :posts='$more_posts'/>
        </div>
    @endif

    
@endsection
