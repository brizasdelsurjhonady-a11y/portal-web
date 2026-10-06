<?php

namespace App\Http\Controllers;

use App\Models\Aplicacion;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AplicacionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATÁLOGO PÚBLICO
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $aplicaciones = Aplicacion::with(['categoria', 'user'])
            ->where('estado', 'publicada')
            ->when($request->q, function ($query, $texto) {
                $query->where(function ($sub) use ($texto) {
                    $sub->where('nombre', 'like', "%{$texto}%")
                        ->orWhere('descripcion', 'like', "%{$texto}%");
                });
            })
            ->when($request->categoria, function ($query, $categoria) {
                $query->where('categoria_id', $categoria);
            })
            ->orderByDesc('destacada')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('aplicaciones.index', [
            'aplicaciones' => $aplicaciones,
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MIS APLICACIONES
    |--------------------------------------------------------------------------
    */

    public function misAplicaciones(Request $request): View
    {
        $aplicaciones = Aplicacion::with('categoria')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('aplicaciones.mis-aplicaciones', compact('aplicaciones'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE REGISTRO
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view('aplicaciones.create', [
            'aplicacion' => new Aplicacion(),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR APLICACIÓN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $datos = $this->validar($request);

        $datos['user_id'] = $request->user()->id;
        $datos['estado'] = 'pendiente';
        $datos['visitas'] = 0;
        $datos['destacada'] = false;

        if ($request->hasFile('logo')) {
            $datos['logo'] = $request->file('logo')->store(
                'logos',
                'public'
            );
        }

        Aplicacion::create($datos);

        return redirect()
            ->route('aplicaciones.mis')
            ->with('ok', 'Aplicación registrada correctamente. Quedó pendiente de aprobación.');
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE EDICIÓN
    |--------------------------------------------------------------------------
    */

    public function edit(Request $request, Aplicacion $aplicacion): View
    {
        abort_unless(
            $aplicacion->user_id === $request->user()->id
            || $request->user()->can('aplicaciones.moderar'),
            403
        );

        return view('aplicaciones.edit', [
            'aplicacion' => $aplicacion,
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR APLICACIÓN
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Aplicacion $aplicacion
    ): RedirectResponse {
        abort_unless(
            $aplicacion->user_id === $request->user()->id
            || $request->user()->can('aplicaciones.moderar'),
            403
        );

        $datos = $this->validar($request);

        /*
        Si un estudiante modifica una aplicación,
        vuelve a quedar pendiente de revisión.
        */

        if (
            $aplicacion->user_id === $request->user()->id
            && ! $request->user()->can('aplicaciones.moderar')
        ) {
            $datos['estado'] = 'pendiente';
            $datos['motivo_rechazo'] = null;
            $datos['destacada'] = false;
        }

        if ($request->hasFile('logo')) {
            if ($aplicacion->logo) {
                Storage::disk('public')->delete($aplicacion->logo);
            }

            $datos['logo'] = $request->file('logo')->store(
                'logos',
                'public'
            );
        }

        $aplicacion->update($datos);

        return redirect()
            ->route('aplicaciones.mis')
            ->with('ok', 'Aplicación actualizada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR APLICACIÓN
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Request $request,
        Aplicacion $aplicacion
    ): RedirectResponse {
        abort_unless(
            $aplicacion->user_id === $request->user()->id
            || $request->user()->can('aplicaciones.moderar'),
            403
        );

        if ($aplicacion->logo) {
            Storage::disk('public')->delete($aplicacion->logo);
        }

        $aplicacion->delete();

        return redirect()
            ->route('aplicaciones.mis')
            ->with('ok', 'Aplicación eliminada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | DETALLE / ABRIR APLICACIÓN
    |--------------------------------------------------------------------------
    */

    public function abrir(Aplicacion $aplicacion): RedirectResponse
    {
        abort_unless($aplicacion->estado === 'publicada', 404);

        $aplicacion->increment('visitas');

        return redirect()->away($aplicacion->url);
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDACIÓN
    |--------------------------------------------------------------------------
    */

    private function validar(Request $request): array
    {
        return $request->validate([
            'categoria_id' => [
                'required',
                'exists:categorias,id',
            ],

            'nombre' => [
                'required',
                'string',
                'max:100',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:2000',
            ],

            'url' => [
                'required',
                'url',
                'max:500',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);
    }
}
