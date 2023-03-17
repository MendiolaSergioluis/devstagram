<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Like;
use App\Models\Post;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username' // Se añade 'username' ya que se agregó este valor a la tabla usuarios
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        // Relación One to Many: Uno a muchos -- Un usuario puede tener multiples posts
        // Se debe especificar el nombre del foreign key y local key en caso de haber
        // modificado los valores por defecto que asigna Laravel según sus convenciones
        // $this->hasMany(Post::class, 'foreign_id', 'local_id');
        return $this->hasMany(Post::class); 
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Almacena los seguidores de un usuario (Followers)
    public function followers()
    {   
        // Un usuario puede tener muchos seguidores: La relación perteneca a muchos usuarios
        // En la relación entre tablas users y followers:
        // La llave de la tabla local es 'user_id'
        // La llave de la tabla foranea es 'follower_id'
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    // Almacena los usuarios que seguimos (Following)
    public function following()
    {   
        // Esto relaciona de forma inversa, muestra los usuarios que estan siguiendo
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }
    // Comprueba si un usuario ya sigue a otro
    public function siguiendo(User $user)
    {
        return $this->followers->contains($user->id);
    }

    
}
