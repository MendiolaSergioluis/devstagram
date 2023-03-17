<!-- Muestra los posts -->
@foreach ($posts as $post)
    <div>
        <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
            <img class="rounded-xl" src="{{ asset('uploads') . '/' . $post->imagen }}"
                alt="Imagen del post {{ $post->titulo }}">
        </a>
    </div>
@endforeach
