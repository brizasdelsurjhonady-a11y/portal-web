```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Detalle de aplicación
                </h2>

                <p class="text-sm text-gray-500">
                    Revisa la información antes de aprobar o rechazar este sitio.
                </p>
            </div>

            <a
                href="{{ route('admin.aplicaciones.index') }}"
                class="inline-flex items-center rounded-lg bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700"
            >
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            @if (session('ok'))
                <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800">
                    {{ session('ok') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                <div class="border-b border-gray-200 p-6">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                        @if ($aplicacion->logo)
                            <img
                                src="{{ asset('storage/' . $aplicacion->logo) }}"
                                alt="{{ $aplicacion->nombre }}"
                                class="h-24 w-24 rounded-xl object-cover"
                            >
                        @else
                            <div class="flex h-24 w-24 items-center justify-center rounded-xl bg-gray-100 text-3xl font-bold text-gray-500">
                                {{ strtoupper(substr($aplicacion->nombre, 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $aplicacion->nombre }}
                            </h1>

                            <p class="mt-1 text-sm text-gray-500">
                                Registrado el {{ $aplicacion->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 p-6 sm:grid-cols-2">

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Estudiante
                        </p>

                        <p class="mt-1 text-gray-900">
                            {{ $aplicacion->user->name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ $aplicacion->user->email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Categoría
                        </p>

                        <p class="mt-1 text-gray-900">
                            {{ $aplicacion->categoria->nombre }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Estado
                        </p>

                        <div class="mt-1">
                            @if ($aplicacion->estado === 'pendiente')
                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">
                                    Pendiente
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
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Visitas
                        </p>

                        <p class="mt-1 text-gray-900">
                            {{ $aplicacion->visitas }}
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-sm font-semibold text-gray-500">
                            Descripción
                        </p>

                        <p class="mt-1 whitespace-pre-line text-gray-900">
                            {{ $aplicacion->descripcion }}
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-sm font-semibold text-gray-500">
                            URL del sitio
                        </p>

                        <a
                            href="{{ $aplicacion->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-1 inline-block break-all text-blue-600 hover:underline"
                        >
                            {{ $aplicacion->url }}
                        </a>
                    </div>

                    @if ($aplicacion->motivo_rechazo)
                        <div class="sm:col-span-2 rounded-lg bg-red-50 p-4">
                            <p class="text-sm font-semibold text-red-800">
                                Motivo del rechazo
                            </p>

                            <p class="mt-1 text-sm text-red-700">
                                {{ $aplicacion->motivo_rechazo }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-200 bg-gray-50 p-6">

                    <div class="flex flex-wrap gap-3">

                        @if ($aplicacion->estado !== 'publicada')
                            <form
                                method="POST"
                                action="{{ route('admin.aplicaciones.aprobar', $aplicacion) }}"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700"
                                >
                                    Aprobar y publicar
                                </button>
                            </form>
                        @endif

                        @if ($aplicacion->estado !== 'rechazada')
                            <button
                                type="button"
                                onclick="document.getElementById('form-rechazo').classList.toggle('hidden')"
                                class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700"
                            >
                                Rechazar
                            </button>
                        @endif

                        @if ($aplicacion->estado === 'publicada')
                            <form
                                method="POST"
                                action="{{ route('admin.aplicaciones.destacar', $aplicacion) }}"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700"
                                >
                                    {{ $aplicacion->destacada ? 'Quitar destacada' : 'Marcar como destacada' }}
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($aplicacion->estado !== 'rechazada')
                        <div
                            id="form-rechazo"
                            class="mt-5 hidden rounded-xl border border-red-200 bg-red-50 p-5"
                        >
                            <h3 class="font-semibold text-red-900">
                                Rechazar aplicación
                            </h3>

                            <p class="mt-1 text-sm text-red-700">
                                Escribe el motivo para que el estudiante pueda saber qué debe corregir.
                            </p>

                            <form
                                method="POST"
                                action="{{ route('admin.aplicaciones.rechazar', $aplicacion) }}"
                                class="mt-4"
                            >
                                @csrf
                                @method('PATCH')

                                <label
                                    for="motivo_rechazo"
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                >
                                    Motivo del rechazo
                                </label>

                                <textarea
                                    id="motivo_rechazo"
                                    name="motivo_rechazo"
                                    rows="4"
                                    required
                                    maxlength="500"
                                    class="w-full rounded-lg border-gray-300"
                                    placeholder="Ejemplo: La URL no funciona o la descripción está incompleta."
                                >{{ old('motivo_rechazo') }}</textarea>

                                @error('motivo_rechazo')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <div class="mt-4 flex gap-3">
                                    <button
                                        type="submit"
                                        class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700"
                                    >
                                        Confirmar rechazo
                                    </button>

                                    <button
                                        type="button"
                                        onclick="document.getElementById('form-rechazo').classList.add('hidden')"
                                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                                    >
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

