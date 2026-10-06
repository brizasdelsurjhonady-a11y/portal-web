<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'AppHub Portal') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-gray-100 font-sans antialiased">


    {{-- =====================================================
         MENÚ LATERAL
    ====================================================== --}}

    @include('layouts.navigation')


    {{-- =====================================================
         CONTENIDO PRINCIPAL
         288px = ancho del menú
    ====================================================== --}}

    <div class="min-h-screen ml-72">


        {{-- =================================================
             BARRA SUPERIOR
        ================================================== --}}

        <header
            class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-gray-200 bg-white px-6 shadow-sm"
        >

            {{-- TÍTULO --}}
            <div>

                <h1 class="text-xl font-bold text-gray-800">
                    AppHub Portal
                </h1>

                <p class="text-sm text-gray-500">
                    Plataforma de proyectos web
                </p>

            </div>


            {{-- USUARIO --}}
            @auth

                <div class="flex items-center gap-3">

                    <div class="hidden text-right sm:block">

                        <p class="text-sm font-semibold text-gray-800">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ Auth::user()->email }}
                        </p>

                    </div>


                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 font-bold text-white shadow"
                    >
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                </div>

            @endauth

        </header>


        {{-- =================================================
             CONTENIDO DE LA PÁGINA
        ================================================== --}}

        <main class="p-6 lg:p-8">

            {{ $slot }}

        </main>


    </div>

</body>

</html>
