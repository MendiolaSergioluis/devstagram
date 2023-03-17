<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    public function user()
    {
        // Relación de pertenencia 'belongsTo' trae todos los datos
        // Para solo traer la infomación necesaria se utiliza 'select' 
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)
    {
        // Comprueba si en la tabla 'likes', en la columna 'user_id' ya existe 
        // un registro del usuario '$user' y retorna un booleano
        return $this->likes->contains('user_id', $user->id);
    }
}
