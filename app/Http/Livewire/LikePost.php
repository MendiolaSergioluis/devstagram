<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{

    // Aquí se guarda los datos de $post que vienen del controlador
    public $post;
    // Aquí se guarda el estado de likes
    public $isLiked;

    // Este es el constructor de Livewire que se ejecuta automáticamente
    public function mount($post)
    {
        // Guarda en 'isLiked' 'true' si el usuario ya dio me gusta o 'false', si aun no ha dado me gusta
        $this->isLiked = $post->checkLike(auth()->user());
    }
    public function like()
    {
        if ($this->post->checkLike(auth()->user())) {
            // Elimina registro de la tabla likes
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            // Si se da click en el botón que ya tiene like, se lo elimina: 'false'
            $this->isLiked = false;

        } else {
            // Añade un registro a la tabla likes
            $this->post->likes()->create([
                'user_id' => auth()->user()->id,
            ]);
            // Si se da click en el botón que no tiene like, se lo agrega: 'true'
            $this->isLiked = true;

        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
