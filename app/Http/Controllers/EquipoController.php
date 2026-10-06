<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Equipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipoController extends Controller
{
    private const ESTADOS = [
        'disponible',
        'prestado',
        'mantenimiento',
        'baja',
    ];

    public function index(Request $request)
    {
        $equipos = Equipo::with('categoria')
            ->when($request->q, function ($query, $texto) {
                $query->where(function ($sub) use ($texto) {
                    $sub->where('nombre', 'like', "%{$texto}%")
                        ->orWhere('codigo', 'like', "%{$texto}%");
                });
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        return view('equipos.create', [
            'equipo' => new Equipo(),
            'categorias' => Categoria::orderBy('nombre')->get(),
            'estados' => self::ESTADOS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Equipo::create($this->validar($request));

        return redirect()
            ->route('equipos.index')
            ->with('ok', 'Equipo registrado correctamente.');
    }

    public function edit(Equipo $equipo)
    {
        return view('equipos.edit', [
            'equipo' => $equipo,
            'categorias' => Categoria::orderBy('nombre')->get(),
            'estados' => self::ESTADOS,
        ]);
    }

    public function update(
        Request $request,
        Equipo $equipo
    ): RedirectResponse {
        $equipo->update($this->validar($request, $equipo));

        return redirect()
            ->route('equipos.index')
            ->with('ok', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipo $equipo): RedirectResponse
    {
        if ($equipo->prestamos()->exists()) {
            return back()->withErrors(
                'No se puede eliminar un equipo con historial de préstamos.'
            );
        }

        $equipo->delete();

        return redirect()
            ->route('equipos.index')
            ->with('ok', 'Equipo eliminado.');
    }

    private function validar(
        Request $request,
        ?Equipo $equipo = null
    ): array {
        return $request->validate([
            'categoria_id' => [
                'required',
                'exists:categorias,id',
            ],

            'codigo' => [
                'required',
                'string',
                'max:30',
                Rule::unique('equipos', 'codigo')
                    ->ignore($equipo?->id),
            ],

            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'marca' => [
                'nullable',
                'string',
                'max:255',
            ],

            'estado' => [
                'required',
                Rule::in(self::ESTADOS),
            ],
        ]);
    }
}
