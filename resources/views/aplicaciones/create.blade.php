```blade id="a3k9lm"
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Registrar aplicación
            </h2>

            <p class="text-sm text-gray-500">
                Registra tu sitio web para enviarlo a revisión del administrador.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-800">
                    <p class="mb-2 font-semibold">
                        Hay algunos errores en el formulario:
                    </p>

                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rounded-2xl bg-white p-6 shadow-sm sm:p-8">

                <form
                    method="POST"
                    action="{{ route('aplicaciones.store') }}"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >
                    @csrf

                    {{-- NOMBRE --}}
                    <div>
                        <label
                            for="nombre"
                            class="mb-1 block text-sm font-semibold text-gray-700"
                        >
                            Nombre del sitio o aplicación
                        </label>

                        <input
                            id="nombre"
                            type="text"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            required
                            maxlength="100"
                            placeholder="Ejemplo: Sistema de Biblioteca"
                            class="w-full rounded-lg border-gray-300"
                        >

                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- CATEGORÍA --}}
                    <div>
                        <label
                            for="categoria_id"
                            class="mb-1 block text-sm font-semibold text-gray-700"
                        >
                            Categoría
                        </label>

                        <select
                            id="categoria_id"
                            name="categoria_id"
                            required
                            class="w-full rounded-lg border-gray-300"
                        >
                            <option value="">
                                Selecciona una categoría
                            </option>

                            @foreach ($categorias as $categoria)
                                <option
                                    value="{{ $categoria->id }}"
                                    @selected(old('categoria_id') == $categoria->id)
                                >
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('categoria_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div>
                        <label
                            for="descripcion"
                            class="mb-1 block text-sm font-semibold text-gray-700"
                        >
                            Descripción
                        </label>

                        <textarea
                            id="descripcion"
                            name="descripcion"
                            rows="5"
                            required
                            maxlength="2000"
                            placeholder="Describe brevemente qué hace tu aplicación..."
                            class="w-full rounded-lg border-gray-300"
                        >{{ old('descripcion') }}</textarea>

                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- URL --}}
                    <div>
                        <label
                            for="url"
                            class="mb-1 block text-sm font-semibold text-gray-700"
                        >
                            URL del sitio web
                        </label>

                        <input
                            id="url"
                            type="url"
                            name="url"
                            value="{{ old('url') }}"
                            required
                            maxlength="500"
                            placeholder="https://ejemplo.com"
                            class="w-full rounded-lg border-gray-300"
                        >

                        <p class="mt-1 text-xs text-gray-500">
                            Debe comenzar con http:// o https://
                        </p>

                        @error('url')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- LOGO --}}
                    <div>
                        <label
                            for="logo"
                            class="mb-1 block text-sm font-semibold text-gray-700"
                        >
                            Logo
                        </label>

                        <input
                            id="logo"
                            type="file"
                            name="logo"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-4 file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold"
                        >

                        <p class="mt-1 text-xs text-gray-500">
                            Formatos permitidos: JPG, JPEG, PNG o WEBP. Máximo 2 MB.
                        </p>

                        @error('logo')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- AVISO --}}
                    <div class="rounded-lg bg-blue-50 p-4">
                        <p class="text-sm text-blue-800">
                            <strong>Importante:</strong>
                            después de registrar tu aplicación, quedará en estado
                            <strong>pendiente</strong>. El administrador deberá revisarla
                            y aprobarla antes de que aparezca públicamente.
                        </p>
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('aplicaciones.mis') }}"
                            class="rounded-lg border border-gray-300 px-5 py-2.5 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                        >
                            Registrar aplicación
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
```
