<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        // $nombreImagen = Str::uuid() . "." . $imagen->extension();
        $nombreImagen = Str::uuid() . '.webp';

        // Genera una instancia de intervention image
        $imagenServidor = Image::make($imagen);
        // Recorta la imagen
        $imagenServidor->fit(500, 500);
        // Genera una ruta con el nombre de la imagen que se va a guardar al servidor
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        // Guarda la imagen en el servidor especificando (ruta, %calidad, formato)
        $imagenServidor->save($imagenPath, 60, 'webp');


        return response()->json(['imagen' => $nombreImagen]);
    }
}
