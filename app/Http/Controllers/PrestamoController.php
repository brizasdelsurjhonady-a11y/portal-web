<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Prestamo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestamo::with(['equipo', 'user'])
            ->latest('fecha_prestamo');

        if (! $request->user()->can('prestamos.ver-todos')) {
            $query->where('user_id', $request->user()->id);
        }

        return view('prestamos.index', [
            'prestamos' => $query->paginate(10),
            'disponibles' => Equipo::where('estado', 'disponible')
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'equipo_id' => [
                'required',
                'exists:equipos,id',
            ],

            'observacion' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        try {
            DB::transaction(function () use ($datos, $request) {

                $equipo = Equipo::lockForUpdate()
                    ->findOrFail($datos['equipo_id']);

                if ($equipo->estado !== 'disponible') {
                    throw new \RuntimeException(
                        'El equipo ya no está disponible.'
                    );
                }

                Prestamo::create([
                    'equipo_id' => $equipo->id,
                    'user_id' => $request->user()->id,
                    'fecha_prestamo' => now(),
                    'observacion' => $datos['observacion'] ?? null,
                    'estado' => 'activo',
                ]);

                $equipo->update([
                    'estado' => 'prestado',
                ]);
            });

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('prestamos.index')
            ->with('ok', 'Préstamo registrado.');
    }

    public function devolver(Prestamo $prestamo): RedirectResponse
    {
        if ($prestamo->estado === 'devuelto') {
            return back()->withErrors(
                'Este préstamo ya fue devuelto.'
            );
        }

        DB::transaction(function () use ($prestamo) {

            $prestamo->update([
                'estado' => 'devuelto',
                'fecha_devolucion' => now(),
            ]);

            $prestamo->equipo->update([
                'estado' => 'disponible',
            ]);
        });

        return back()->with(
            'ok',
            'Devolución registrada.'
        );
    }
}
