<?php

namespace App\Http\Controllers;

use App\Models\Aplicacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAplicacionController extends Controller
{
    /**
     * Mostrar aplicaciones pendientes de revisión.
     */
    public function index(Request $request): View
    {
        $aplicaciones = Aplicacion::with(['categoria', 'user'])
            ->when($request->estado, function ($query, $estado) {
                $query->where('estado', $estado);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.aplicaciones.index', compact('aplicaciones'));
    }

    /**
     * Mostrar detalle de una aplicación.
     */
    public function show(Aplicacion $aplicacion): View
    {
        $aplicacion->load(['categoria', 'user']);

        return view('admin.aplicaciones.show', compact('aplicacion'));
    }

    /**
     * Aprobar aplicación.
     */
    public function aprobar(Aplicacion $aplicacion): RedirectResponse
    {
        $aplicacion->update([
            'estado' => 'publicada',
            'motivo_rechazo' => null,
        ]);

        return back()->with(
            'ok',
            'La aplicación fue aprobada y publicada correctamente.'
        );
    }

    /**
     * Rechazar aplicación.
     */
    public function rechazar(
        Request $request,
        Aplicacion $aplicacion
    ): RedirectResponse {
        $datos = $request->validate([
            'motivo_rechazo' => [
                'required',
                'string',
                'max:500',
            ],
        ]);

        $aplicacion->update([
            'estado' => 'rechazada',
            'motivo_rechazo' => $datos['motivo_rechazo'],
            'destacada' => false,
        ]);

        return back()->with(
            'ok',
            'La aplicación fue rechazada correctamente.'
        );
    }

    /**
     * Marcar o quitar como destacada.
     */
    public function destacar(Aplicacion $aplicacion): RedirectResponse
    {
        $aplicacion->update([
            'destacada' => ! $aplicacion->destacada,
        ]);

        return back()->with(
            'ok',
            $aplicacion->destacada
                ? 'Aplicación marcada como destacada.'
                : 'La aplicación dejó de estar destacada.'
        );
    }
}
