```blade
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Editar aplicación
            </h2>

            <p class="text-sm text-gray-500">
                Modifica los datos de tu aplicación.
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
                    action="{{ route('aplicaciones.update', $aplicacion) }}"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >
                    @csrf
                    @method('PUT')

                    {{-- ESTADO ACTUAL --}}
                    <div class="rounded-lg bg-gray-50 p-4">
                        <p class="text-sm font-semibold text-gray-700">
                            Estado actual
                        </p>

                        <div class="mt-2">
                            @if ($aplicacion->estado === 'pendiente')
                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">
                                    Pendiente de aprobación
                                </span>
                            @elseif ($aplicacion->estado === 'publicada')
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                    Publicada
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                                    Rechazada
                                </span>
                            @endif
                        </div>

                        @if ($aplicacion->estado === 'rechazada' && $aplicacion->motivo_rechazo)
                            <p class="mt-3 text-sm text-red-700">
                                <strong>Motivo:</strong>
                                {{ $aplicacion->motivo_rechazo }}
                            </p>
                        @endif
                    </div>

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
                            value="{{ old('nombre', $aplicacion->nombre) }}"
                            required
                            maxlength="100"
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
                                    @selected(old('categoria_id', $aplicacion->categoria_id) == $categoria->id)
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
                            class="w-full rounded-lg border-gray-300"
                        >{{ old('descripcion', $aplicacion->descripcion) }}</textarea>

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
                            value="{{ old('url', $aplicacion->url) }}"
                            required
                            maxlength="500"
                            class="w-full rounded-lg border-gray-300"
                        >

                        @error('url')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- LOGO ACTUAL --}}
                    <div>
                        <p class="mb-2 text-sm font-semibold text-gray-700">
                            Logo actual
                        </p>

                        @if ($aplicacion->logo)
                            <img
                                src="{{ asset('storage/' . $aplicacion->logo) }}"
                                alt="{{ $aplicacion->nombre }}"
                                class="h-24 w-24 rounded-xl object-cover"
                            >
                        @else
                            <div class="flex h-24 w-24 items-center justify-center rounded-xl bg-gray-100 text-2xl font-bold text-gray-500">
                                {{ strtoupper(substr($aplicacion->nombre, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- NUEVO LOGO --}}
                    <div>
                        <label
                            for="logo"
                            class="mb-1 block text-sm font-semibold text-gray-700"
                        >
                            Cambiar logo
                        </label>

                        <input
                            id="logo"
                            type="file"
                            name="logo"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-4 file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold"
                        >

                        <p class="mt-1 text-xs text-gray-500">
                            Opcional. JPG, JPEG, PNG o WEBP. Máximo 2 MB.
                        </p>

                        @error('logo')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- AVISO --}}
                    <div class="rounded-lg bg-yellow-50 p-4">
                        <p class="text-sm text-yellow-800">
                            <strong>Importante:</strong>
                            si modificas tu aplicación mientras eres estudiante,
                            volverá a quedar en estado <strong>pendiente</strong>
                            para que el administrador pueda revisarla nuevamente.
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
                            Guardar cambios
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
```
