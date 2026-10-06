@csrf

<div class="grid gap-4 sm:grid-cols-2">

    {{-- Código --}}
    <div>
        <label class="block text-sm font-medium">
            Código
        </label>

        <input
            type="text"
            name="codigo"
            value="{{ old('codigo', $equipo->codigo) }}"
            class="w-full border-gray-300 rounded-md"
        >

        @error('codigo')
            <p class="text-red-600 text-sm">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Nombre --}}
    <div>
        <label class="block text-sm font-medium">
            Nombre
        </label>

        <input
            type="text"
            name="nombre"
            value="{{ old('nombre', $equipo->nombre) }}"
            class="w-full border-gray-300 rounded-md"
        >

        @error('nombre')
            <p class="text-red-600 text-sm">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Marca --}}
    <div>
        <label class="block text-sm font-medium">
            Marca
        </label>

        <input
            type="text"
            name="marca"
            value="{{ old('marca', $equipo->marca) }}"
            class="w-full border-gray-300 rounded-md"
        >
    </div>

    {{-- Categoría --}}
    <div>
        <label class="block text-sm font-medium">
            Categoría
        </label>

        <select
            name="categoria_id"
            class="w-full border-gray-300 rounded-md"
        >
            @foreach ($categorias as $cat)

                <option
                    value="{{ $cat->id }}"
                    @selected(old('categoria_id', $equipo->categoria_id) == $cat->id)
                >
                    {{ $cat->nombre }}
                </option>

            @endforeach
        </select>
    </div>

    {{-- Estado --}}
    <div>
        <label class="block text-sm font-medium">
            Estado
        </label>

        <select
            name="estado"
            class="w-full border-gray-300 rounded-md"
        >
            @foreach ($estados as $estado)

                <option
                    value="{{ $estado }}"
                    @selected(
                        old(
                            'estado',
                            $equipo->estado ?? 'disponible'
                        ) == $estado
                    )
                >
                    {{ ucfirst($estado) }}
                </option>

            @endforeach
        </select>
    </div>

</div>

{{-- Botones --}}
<div class="mt-6 flex gap-3">

    <button
        type="submit"
        class="px-4 py-2 bg-indigo-600 text-white rounded-md"
    >
        Guardar
    </button>

    <a
        href="{{ route('equipos.index') }}"
        class="px-4 py-2 bg-gray-200 rounded-md"
    >
        Cancelar
    </a>

</div>s
