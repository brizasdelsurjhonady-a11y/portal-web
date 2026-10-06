{{-- =========================================================
     MENÚ LATERAL FIJO - APPHUB PORTAL
========================================================= --}}

<aside class="fixed inset-y-0 left-0 z-50 w-72 bg-gray-900 text-white shadow-2xl">

    <div class="flex h-full flex-col">

        {{-- LOGO --}}
        <div class="flex h-20 items-center border-b border-gray-800 px-6">

            <a href="{{ route('inicio') }}" class="flex items-center gap-3">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-xl font-bold shadow-lg">
                    A
                </div>

                <div>
                    <h2 class="text-lg font-bold">
                        AppHub
                    </h2>

                    <p class="text-xs text-gray-400">
                        Portal de aplicaciones
                    </p>
                </div>

            </a>

        </div>


        {{-- MENÚ PRINCIPAL --}}
        <nav class="flex-1 space-y-2 overflow-y-auto px-4 py-6">

            {{-- INICIO --}}
            <a
                href="{{ route('inicio') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white"
            >
                <span class="text-lg">⌂</span>
                <span>Inicio</span>
            </a>


            {{-- APLICACIONES --}}
            <a
                href="{{ route('aplicaciones.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white"
            >
                <span class="text-lg">▣</span>
                <span>Aplicaciones</span>
            </a>


            @auth

                {{-- SEPARADOR --}}
                <div class="my-5 border-t border-gray-800"></div>


                {{-- MI CUENTA --}}
                <p class="px-4 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Mi cuenta
                </p>


                {{-- MIS APLICACIONES --}}
                <a
                    href="{{ route('aplicaciones.mis') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white"
                >
                    <span class="text-lg">▤</span>
                    <span>Mis aplicaciones</span>
                </a>


                {{-- REGISTRAR --}}
                <a
                    href="{{ route('aplicaciones.create') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white"
                >
                    <span class="text-lg">+</span>
                    <span>Registrar aplicación</span>
                </a>


                @can('aplicaciones.moderar')

                    {{-- SEPARADOR --}}
                    <div class="my-5 border-t border-gray-800"></div>


                    {{-- ADMINISTRACIÓN --}}
                    <p class="px-4 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Administración
                    </p>


                    {{-- PANEL ADMINISTRADOR --}}
                    <a
                        href="{{ route('admin.aplicaciones.index') }}"
                        class="flex items-center gap-3 rounded-xl bg-blue-600 px-4 py-3 text-sm font-medium text-white shadow-lg transition hover:bg-blue-700"
                    >
                        <span class="text-lg">⚙</span>
                        <span>Panel administrador</span>
                    </a>

                @endcan

            @endauth

        </nav>


        {{-- PARTE INFERIOR --}}
        <div class="border-t border-gray-800 p-4">

            @auth

                {{-- USUARIO --}}
                <div class="mb-3 flex items-center gap-3 rounded-xl bg-gray-800 p-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-600 font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">

                        <p class="truncate text-sm font-semibold">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="truncate text-xs text-gray-400">
                            {{ Auth::user()->email }}
                        </p>

                    </div>

                </div>


                {{-- PERFIL --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-300 transition hover:bg-gray-800 hover:text-white"
                >
                    <span class="text-lg">◉</span>
                    <span>Mi perfil</span>
                </a>


                {{-- CERRAR SESIÓN --}}
                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm text-red-400 transition hover:bg-red-500/10"
                    >
                        <span class="text-lg">↪</span>
                        <span>Cerrar sesión</span>
                    </button>

                </form>

            @else

                {{-- INICIAR SESIÓN --}}
                <a
                    href="{{ route('login') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-300 transition hover:bg-gray-800 hover:text-white"
                >
                    <span class="text-lg">→</span>
                    <span>Iniciar sesión</span>
                </a>


                {{-- CREAR CUENTA --}}
                <a
                    href="{{ route('register') }}"
                    class="flex items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                >
                    Crear cuenta
                </a>

            @endauth

        </div>

    </div>

</aside>