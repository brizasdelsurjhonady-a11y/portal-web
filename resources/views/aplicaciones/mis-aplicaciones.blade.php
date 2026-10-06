```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Mis aplicaciones
                </h2>

                <p class="text-sm text-gray-500">
                    Administra los sitios web que has registrado en AppHub Portal.
                </p>
            </div>

            <a
                href="{{ route('aplicaciones.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
            >
                + Registrar aplicación
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('ok'))
                <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800">
                    {{ session('ok') }}
                </div>
            @endif

            @if ($aplicaciones->count())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($aplicaciones as $aplicacion)
                        <article class="overflow-hidden rounded-2xl bg-white shadow-sm">

                            {{-- LOGO --}}
                            <div class="flex h-40 items-center justify-center bg-gray-100">

                                @if ($aplicacion->logo)
                                    <img
                                        src="{{ asset('storage/' . $aplicacion->logo) }}"
                                        alt="{{ $aplicacion->nombre }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-gray-200 text-3xl font-bold text-gray-500">
                                        {{ strtoupper(substr($aplicacion->nombre, 0, 1)) }}
                                    </div>
                                @endif

                            </div>

                            <div class="p-5">

                                {{-- NOMBRE Y ESTADO --}}
                                <div class="mb-3">
                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ $aplicacion->nombre }}
                                    </h3>

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
                                </div>

                                {{-- DESCRIPCIÓN --}}
                                <p class="mb-4 line-clamp-3 text-sm leading-6 text-gray-600">
                                    {{ $aplicacion->descripcion }}
                                </p>

                                {{-- INFORMACIÓN --}}
                                <div class="mb-4 space-y-2 text-sm">

                                    <div class="flex justify-between gap-4">
                                        <span class="text-gray-500">
                                            Categoría
                                        </span>

                                        <span class="font-medium text-gray-800">
                                            {{ $aplicacion->categoria->nombre }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between gap-4">
                                        <span class="text-gray-500">
                                            Visitas
                                        </span>

                                        <span class="font-medium text-gray-800">
                                            {{ $aplicacion->visitas }}
                                        </span>
                                    </div>

                                </div>

                                {{-- MOTIVO DEL RECHAZO --}}
                                @if ($aplicacion->estado === 'rechazada' && $aplicacion->motivo_rechazo)
                                    <div class="mb-4 rounded-lg bg-red-50 p-3">
                                        <p class="text-xs font-semibold text-red-800">
                                            Motivo del rechazo
                                        </p>

                                        <p class="mt-1 text-sm text-red-700">
                                            {{ $aplicacion->motivo_rechazo }}
                                        </p>
                                    </div>
                                @endif

                                {{-- ACCIONES --}}
                                <div class="flex flex-wrap gap-2 border-t border-gray-100 pt-4">

                                    <a
                                        href="{{ route('aplicaciones.edit', $aplicacion) }}"
                                        class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-200"
                                    >
                                        Editar
                                    </a>

                                    @if ($aplicacion->estado === 'publicada')
                                        <a
                                            href="{{ route('aplicaciones.abrir', $aplicacion) }}"
                                            target="_blank"
                                            class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700"
                                        >
                                            Abrir sitio
                                        </a>
                                    @endif

                                    <form
                                        method="POST"
                                        action="{{ route('aplicaciones.destroy', $aplicacion) }}"
                                        onsubmit="return confirm('¿Estás seguro de eliminar esta aplicación?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200"
                                        >
                                            Eliminar
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </article>
                    @endforeach

                </div>

                @if ($aplicaciones->hasPages())
                    <div class="mt-8">
                        {{ $aplicaciones->links() }}
                    </div>
                @endif

            @else

                <div class="rounded-2xl bg-white p-12 text-center shadow-sm">

                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <span class="text-2xl">
                            🌐
                        </span>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900">
                        Todavía no tienes aplicaciones
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Registra tu primer sitio web para enviarlo a revisión.
                    </p>

                    <a
                        href="{{ route('aplicaciones.create') }}"
                        class="mt-5 inline-flex rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        Registrar mi primera aplicación
                    </a>

                </div>

            @endif

        </div>
    </div>
</x-app-layout>
```
