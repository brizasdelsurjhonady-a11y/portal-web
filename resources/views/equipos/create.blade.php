<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo equipo
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow sm:rounded-lg p-6">

            <form method="POST" action="{{ route('equipos.store') }}">

                @include('equipos._form')

            </form>

        </div>

    </div>

</x-app-layout>
