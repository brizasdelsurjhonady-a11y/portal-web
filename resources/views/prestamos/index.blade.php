<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Préstamos
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Mensaje de éxito --}}
        @if (session('ok'))
            <div class="p-3 rounded bg-green-100 text-green-800">
                {{ session('ok') }}
            </div>
        @endif

        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="p-3 rounded bg-red-100 text-red-800">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Solicitar equipo --}}
        @can('prestamos.registrar')

            <div class="bg-white shadow sm:rounded-lg p-6">

                <h3 class="font-semibold mb-3">
                    Solicitar un equipo
                </h3>

                <form
                    method="POST"
                    action="{{ route('prestamos.store') }}"
                    class="flex flex-wrap gap-3"
                >

                    @csrf

                    <select
                        name="equipo_id"
                        class="border-gray-300 rounded-md"
                        required
                    >
                        <option value="">
                            Seleccione un equipo disponible
                        </option>

                        @foreach ($disponibles as $eq)

                            <option value="{{ $eq->id }}">
                                {{ $eq->codigo }} - {{ $eq->nombre }}
                            </option>

                        @endforeach

                    </select>

                    <input
                        type="text"
                        name="observacion"
                        placeholder="Observación (opcional)"
                        class="border-gray-300 rounded-md"
                    >

                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                    >
                        Solicitar
                    </button>

                </form>

            </div>

        @endcan

        {{-- Tabla de préstamos --}}
        <div class="bg-white shadow sm:rounded-lg p-6 overflow-x-auto">

            <table class="min-w-full text-sm text-left">

                <thead class="bg-gray-100 text-gray-700">

                    <tr>

                        <th class="p-2">
                            Equipo
                        </th>

                        <th class="p-2">
                            Usuario
                        </th>

                        <th class="p-2">
                            Prestado
                        </th>

                        <th class="p-2">
                            Devuelto
                        </th>

                        <th class="p-2">
                            Estado
                        </th>

                        @can('prestamos.gestionar')
                            <th class="p-2">
                                Acción
                            </th>
                        @endcan

                    </tr>

                </thead>

                <tbody>

                    @forelse ($prestamos as $p)

                        <tr class="border-b">

                            <td class="p-2">
                                {{ $p->equipo->codigo }}
                                -
                                {{ $p->equipo->nombre }}
                            </td>

                            <td class="p-2">
                                {{ $p->user->name }}
                            </td>

                            <td class="p-2">
                                {{ $p->fecha_prestamo->format('d/m/Y H:i') }}
                            </td>

                            <td class="p-2">
                                {{ $p->fecha_devolucion?->format('d/m/Y H:i') ?? '-' }}
                            </td>

                            <td class="p-2">
                                {{ ucfirst($p->estado) }}
                            </td>

                            @can('prestamos.gestionar')

                                <td class="p-2">

                                    @if ($p->estado === 'activo')

                                        <form
                                            method="POST"
                                            action="{{ route('prestamos.devolver', $p) }}"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="text-indigo-600"
                                            >
                                                Registrar devolución
                                            </button>

                                        </form>

                                    @endif

                                </td>

                            @endcan

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="p-4 text-center text-gray-500"
                            >
                                Sin préstamos.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $prestamos->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
