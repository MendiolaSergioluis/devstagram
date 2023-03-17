@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{ auth()->user()->username }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6 mx-4 md:mx-0">
            <form class="mt-10 md:mt-0" action="{{ route('perfil.store', auth()->user()->username) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- USERNAME -->
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Username
                    </label>
                    <input id="username" name="username" type="text" placeholder="Tu Nombre de Usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{ auth()->user()->username }}" />
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <!-- IMAGEN PERFIL -->
                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen Perfil
                    </label>
                    <input id="imagen" name="imagen" type="file" accept=".jpg,.jpeg,.png,.webp"
                        class="border p-3 w-full rounded-lg" value="" />

                </div>
                <!-- NUEVO EMAIL -->
                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>
                    <input id="email" name="email" type="text" placeholder="Nuevo Email"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ auth()->user()->email }}" />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CAMBIO DE PASSWORD -->
                <div class="mb-5">
                    <label for="old_password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password Actual
                    </label>
                    <input 
                        id="old_password"
                        name="old_password"
                        type="password"
                        placeholder="Escribe tu password actual"
                        class="border p-3 w-full rounded-lg @error('old_password') border-red-500 @enderror"
                    />
                    @if (session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ session('mensaje') }}</p>
                    @endif
                    @error('old_password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password
                    </label>
                    <input 
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Password de Registro"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror"
                    />
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">
                        Repetir Password
                    </label>
                    <input 
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="Confirma tu Password"
                        class="border p-3 w-full rounded-lg"
                    />

                </div>

                <!-- BOTÓN -->
                <input type="submit" value="Guardar cambios"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full md:w-auto p-3 text-white rounded-lg" />
            </form>
        </div>
    </div>
@endsection
