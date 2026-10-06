<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Equipos
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">

        {{-- Mensaje de éxito --}}
        @if (session('ok'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('ok') }}
            </div>
        @endif

        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-white shadow sm:rounded-lg p-6">

            <div class="flex flex-wrap gap-3 justify-between mb-4">

                {{-- Buscador --}}
                <form method="GET" class="flex gap-2">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Buscar por nombre o código"
                        class="border-gray-300 rounded-md shadow-sm"
                    >

                    <button
                        type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md"
                    >
                        Buscar
                    </button>
                </form>

                {{-- Nuevo equipo --}}
                @can('equipos.gestionar')
                    <a
                        href="{{ route('equipos.create') }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                    >
                        Nuevo equipo
                    </a>
                @endcan

            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto">

                <table class="min-w-full text-sm text-left">

                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-2">Código</th>
                            <th class="p-2">Nombre</th>
                            <th class="p-2">Marca</th>
                            <th class="p-2">Categoría</th>
                            <th class="p-2">Estado</th>

                            @can('equipos.gestionar')
                                <th class="p-2">Acciones</th>
                            @endcan
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($equipos as $equipo)

                            <tr class="border-b">

                                <td class="p-2">
                                    {{ $equipo->codigo }}
                                </td>

                                <td class="p-2">
                                    {{ $equipo->nombre }}
                                </td>

                                <td class="p-2">
                                    {{ $equipo->marca }}
                                </td>

                                <td class="p-2">
                                    {{ $equipo->categoria->nombre }}
                                </td>

                                <td class="p-2">

                                    <span class="px-2 py-1 rounded text-xs
                                        {{ $equipo->estado === 'disponible'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-yellow-100 text-yellow-800' }}">

                                        {{ ucfirst($equipo->estado) }}

                                    </span>

                                </td>

                                @can('equipos.gestionar')

                                    <td class="p-2 flex gap-2">

                                        <a
                                            href="{{ route('equipos.edit', $equipo) }}"
                                            class="text-indigo-600"
                                        >
                                            Editar
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('equipos.destroy', $equipo) }}"
                                            onsubmit="return confirm('¿Eliminar este equipo?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-600"
                                            >
                                                Eliminar
                                            </button>
                                        </form>

                                    </td>

                                @endcan

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="6"
                                    class="p-4 text-center text-gray-500"
                                >
                                    Sin resultados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $equipos->links() }}
            </div>

        </div>

    </div>
</x-app-layout>
