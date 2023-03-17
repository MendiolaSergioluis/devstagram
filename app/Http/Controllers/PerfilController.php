<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        if (auth()->user()->id === $user->id) {
            return view('perfil.index', ['user' => $user]);
        } else {
            // Con el siguiente código se redirige al usuario hacia la edición de su propio perfil
            // return redirect()->route('perfil.index', ['user'=>auth()->user()->username]);

            // El siguiente código envía un mensaje de error: '403 | FORBIDDEN'
            abort(403);
        }
    }

    public function store(Request $request)
    {
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        // Así como 'not_in:', también existe la opción 'in:' para especificar un listado de opciones válidas.
        // 'in:cliente,vendedor,administrador,gerente'
        $this->validate($request, [
            'username' => [
                'required',
                // https://laravel.com/docs/10.x/validation#rule-unique
                Rule::unique('users', 'username')->ignore(auth()->user()->id),
                'min:3',
                'max:20',
                'not_in:editar-perfil,twitter,posts'
            ],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore(auth()->user()->id),
                'email',
                'max:60'
            ],
        ]);

        // Si existe una imagen en el $request, entonces...
        if ($request->imagen) {
            // Si existe un archivo de imagen en este usuario:
            if (auth()->user()->imagen) {
                // Si el usuario tiene una imagen previa la elimina
                $imagen_previa = 'perfiles/' . auth()->user()->imagen;
                if (File::exists($imagen_previa)) {
                    // Elimina la imagen del servidor
                    unlink(public_path($imagen_previa));
                }
            }

            // Toma el archivo de imagen del request
            $imagen = $request->file('imagen');

            // Asigna un nombre único
            // $nombreImagen = Str::uuid() . "." . $imagen->extension();
            $nombreImagen = Str::uuid() . '.webp';

            // Genera una instancia de intervention image
            $imagenServidor = Image::make($imagen);
            // Recorta la imagen
            $imagenServidor->fit(500, 500);
            // Genera una ruta con el nombre de la imagen que se va a guardar al servidor
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            // Guarda la imagen en el servidor especificando (ruta, %calidad, formato)
            $imagenServidor->save($imagenPath, 60, 'webp');
        }

        //Genera una instancia del modelo User correspondiente al 'id' del usuario actual
        $usuario = User::find(auth()->user()->id);

        // CAMBIA LA CONTRASEÑA

        if ($request->old_password || $request->password) {

            $this->validate($request, [
                'old_password' => ['required', 'current_password', 'min:6'],
                'password' => ['required', 'confirmed', 'min:6']
            ]);

            if (Hash::check($request->old_password, $usuario->password)) {
                $usuario->password = Hash::make($request->password);
            } else {
                return redirect()->route('post.index', $usuario->username);
            }
        }

        // GUARDANDO CAMBIOS
        // Asigna el nuevo valor de username al usuario de la base de datos
        $usuario->username = $request->username;
        // Asigna el nuevo valor de email al usuario de la base de datos
        $usuario->email = $request->email;
        // Guarda la imagen al usuario actual
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? '';
        // Guarda los todos los cambios a '$usuario'
        $usuario->save();

        // REDIRECCIONAR
        return redirect()->route('post.index', $usuario->username);
    }
}
