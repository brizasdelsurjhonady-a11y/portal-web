```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    AppHub Portal
                </h2>

                <p class="text-sm text-gray-500">
                    Encuentra y visita los proyectos web de nuestros estudiantes.
                </p>
            </div>

            @auth
                <a
                    href="{{ route('aplicaciones.mis') }}"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    Mis aplicaciones
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    Iniciar sesión
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- BUSCADOR Y FILTROS --}}
            <div class="mb-8 rounded-2xl bg-white p-6 shadow-sm">

                <form
                    method="GET"
                    action="{{ route('aplicaciones.index') }}"
                    class="grid gap-4 md:grid-cols-4"
                >
                    <div class="md:col-span-2">
                        <label
                            for="q"
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Buscar
                        </label>

                        <input
                            id="q"
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Buscar por nombre o descripción..."
                            class="w-full rounded-lg border-gray-300"
                        >
                    </div>

                    <div>
                        <label
                            for="categoria"
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Categoría
                        </label>

                        <select
                            id="categoria"
                            name="categoria"
                            class="w-full rounded-lg border-gray-300"
                        >
                            <option value="">
                                Todas las categorías
                            </option>

                            @foreach ($categorias as $categoria)
                                <option
                                    value="{{ $categoria->id }}"
                                    @selected((string) request('categoria') === (string) $categoria->id)
                                >
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="w-full rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700"
                        >
                            Buscar
                        </button>
                    </div>
                </form>
            </div>

            {{-- MENSAJE --}}
            @if (session('ok'))
                <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800">
                    {{ session('ok') }}
                </div>
            @endif

            {{-- APLICACIONES DESTACADAS --}}
            @if ($aplicaciones->count())
                <div class="mb-8">
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-gray-900">
                            Proyectos publicados
                        </h3>

                        <p class="text-sm text-gray-500">
                            Explora los sitios web disponibles en el portal.
                        </p>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach ($aplicaciones as $aplicacion)

                            <article class="overflow-hidden rounded-2xl bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                                {{-- LOGO --}}
                                <div class="flex h-44 items-center justify-center bg-gray-100">

                                    @if ($aplicacion->logo)
                                        <img
                                            src="{{ asset('storage/' . $aplicacion->logo) }}"
                                            alt="{{ $aplicacion->nombre }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <div class="flex h-24 w-24 items-center justify-center rounded-2xl bg-gray-200 text-4xl font-bold text-gray-500">
                                            {{ strtoupper(substr($aplicacion->nombre, 0, 1)) }}
                                        </div>
                                    @endif

                                </div>

                                {{-- INFORMACIÓN --}}
                                <div class="p-5">

                                    <div class="mb-3 flex items-start justify-between gap-3">

                                        <h4 class="text-lg font-bold text-gray-900">
                                            {{ $aplicacion->nombre }}
                                        </h4>

                                        @if ($aplicacion->destacada)
                                            <span class="shrink-0 rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-yellow-800">
                                                Destacada
                                            </span>
                                        @endif

                                    </div>

                                    <p class="mb-4 line-clamp-3 text-sm leading-6 text-gray-600">
                                        {{ $aplicacion->descripcion }}
                                    </p>

                                    <div class="mb-4 flex flex-wrap gap-2">

                                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                            {{ $aplicacion->categoria->nombre }}
                                        </span>

                                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                            {{ $aplicacion->visitas }} visitas
                                        </span>

                                    </div>

                                    <div class="flex items-center justify-between border-t border-gray-100 pt-4">

                                        <div>
                                            <p class="text-xs text-gray-400">
                                                Publicado por
                                            </p>

                                            <p class="text-sm font-medium text-gray-700">
                                                {{ $aplicacion->user->name }}
                                            </p>
                                        </div>

                                        <a
                                            href="{{ route('aplicaciones.abrir', $aplicacion) }}"
                                            target="_blank"
                                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                                        >
                                            Abrir
                                        </a>

                                    </div>

                                </div>
                            </article>

                        @endforeach

                    </div>
                </div>
            @else

                <div class="rounded-2xl bg-white p-12 text-center shadow-sm">

                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <span class="text-2xl">
                            🌐
                        </span>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900">
                        No hay aplicaciones publicadas
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Todavía no existen proyectos disponibles en el portal.
                    </p>

                    @auth
                        <a
                            href="{{ route('aplicaciones.create') }}"
                            class="mt-5 inline-flex rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                        >
                            Registrar mi aplicación
                        </a>
                    @endauth

                </div>

            @endif

            {{-- PAGINACIÓN --}}
            @if ($aplicaciones->hasPages())
                <div class="mt-8">
                    {{ $aplicaciones->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
```
