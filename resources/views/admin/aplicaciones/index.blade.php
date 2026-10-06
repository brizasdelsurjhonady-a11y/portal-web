<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Administración de aplicaciones
                </h2>

                <p class="text-sm text-gray-500">
                    Revisa y administra los sitios web registrados por los estudiantes.
                </p>
            </div>

            <a
                href="{{ route('aplicaciones.index') }}"
                class="inline-flex items-center rounded-lg bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700"
            >
                Ver portal público
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Mensaje de éxito --}}
            @if (session('ok'))
                <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800">
                    {{ session('ok') }}
                </div>
            @endif

            {{-- Errores --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Filtro --}}
            <div class="mb-6 rounded-xl bg-white p-5 shadow-sm">
                <form
                    method="GET"
                    action="{{ route('admin.aplicaciones.index') }}"
                    class="flex flex-col gap-4 sm:flex-row sm:items-end"
                >
                    <div class="w-full sm:max-w-xs">
                        <label
                            for="estado"
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Filtrar por estado
                        </label>

                        <select
                            id="estado"
                            name="estado"
                            class="w-full rounded-lg border-gray-300"
                        >
                            <option value="">Todos</option>

                            <option
                                value="pendiente"
                                @selected(request('estado') === 'pendiente')
                            >
                                Pendientes
                            </option>

                            <option
                                value="publicada"
                                @selected(request('estado') === 'publicada')
                            >
                                Publicadas
                            </option>

                            <option
                                value="rechazada"
                                @selected(request('estado') === 'rechazada')
                            >
                                Rechazadas
                            </option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        Filtrar
                    </button>

                    <a
                        href="{{ route('admin.aplicaciones.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        Limpiar
                    </a>
                </form>
            </div>

            {{-- Tabla --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Aplicación
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Estudiante
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Categoría
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Estado
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Visitas
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse ($aplicaciones as $aplicacion)

                                <tr class="hover:bg-gray-50">

                                    {{-- Aplicación --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">

                                            @if ($aplicacion->logo)
                                                <img
                                                    src="{{ asset('storage/' . $aplicacion->logo) }}"
                                                    alt="{{ $aplicacion->nombre }}"
                                                    class="h-12 w-12 rounded-lg object-cover"
                                                >
                                            @else
                                                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-lg font-bold text-gray-500">
                                                    {{ strtoupper(substr($aplicacion->nombre, 0, 1)) }}
                                                </div>
                                            @endif

                                            <div>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $aplicacion->nombre }}
                                                </p>

                                                <p class="max-w-xs truncate text-sm text-gray-500">
                                                    {{ $aplicacion->descripcion }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Estudiante --}}
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $aplicacion->user->name }}
                                    </td>

                                    {{-- Categoría --}}
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $aplicacion->categoria->nombre }}
                                    </td>

                                    {{-- Estado --}}
                                    <td class="px-6 py-4">

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

                                    </td>

                                    {{-- Visitas --}}
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $aplicacion->visitas }}
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="px-6 py-4 text-right">

                                        <div class="flex flex-wrap justify-end gap-2">

                                            {{-- Ver --}}
                                            <a
                                                href="{{ route('admin.aplicaciones.show', $aplicacion) }}"
                                                class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-200"
                                            >
                                                Ver
                                            </a>

                                            {{-- Aprobar --}}
                                            @if ($aplicacion->estado !== 'publicada')
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.aplicaciones.aprobar', $aplicacion) }}"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700"
                                                    >
                                                        Aprobar
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Rechazar --}}
                                            @if ($aplicacion->estado !== 'rechazada')
                                                <a
                                                    href="{{ route('admin.aplicaciones.show', $aplicacion) }}"
                                                    class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700"
                                                >
                                                    Rechazar
                                                </a>
                                            @endif

                                            {{-- Destacar --}}
                                            @if ($aplicacion->estado === 'publicada')
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.aplicaciones.destacar', $aplicacion) }}"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700"
                                                    >
                                                        {{ $aplicacion->destacada ? 'Quitar destacada' : 'Destacar' }}
                                                    </button>
                                                </form>
                                            @endif

                                        </div>

                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="6"
                                        class="px-6 py-12 text-center text-gray-500"
                                    >
                                        No hay aplicaciones registradas.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if ($aplicaciones->hasPages())
                    <div class="border-t border-gray-200 px-6 py-4">
                        {{ $aplicaciones->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
