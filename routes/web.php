<?php

use App\Http\Controllers\AplicacionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PORTAL PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get('/', [AplicacionController::class, 'index'])
    ->name('inicio');

Route::get('/aplicaciones', [AplicacionController::class, 'index'])
    ->name('aplicaciones.index');

Route::get('/aplicaciones/{aplicacion}/abrir', [
    AplicacionController::class,
    'abrir'
])->name('aplicaciones.abrir');

/*
|--------------------------------------------------------------------------
| USUARIOS AUTENTICADOS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | MIS APLICACIONES
    |--------------------------------------------------------------------------
    */

    Route::get('/mis-aplicaciones', [
        AplicacionController::class,
        'misAplicaciones'
    ])
        ->middleware('permission:aplicaciones.ver')
        ->name('aplicaciones.mis');

    /*
    |--------------------------------------------------------------------------
    | REGISTRAR APLICACIÓN
    |--------------------------------------------------------------------------
    */

    Route::get('/aplicaciones/crear', [
        AplicacionController::class,
        'create'
    ])
        ->middleware('permission:aplicaciones.crear')
        ->name('aplicaciones.create');

    Route::post('/aplicaciones', [
        AplicacionController::class,
        'store'
    ])
        ->middleware('permission:aplicaciones.crear')
        ->name('aplicaciones.store');

    /*
    |--------------------------------------------------------------------------
    | EDITAR APLICACIÓN
    |--------------------------------------------------------------------------
    */

    Route::get('/aplicaciones/{aplicacion}/editar', [
        AplicacionController::class,
        'edit'
    ])
        ->middleware('permission:aplicaciones.editar-propias')
        ->name('aplicaciones.edit');

    Route::put('/aplicaciones/{aplicacion}', [
        AplicacionController::class,
        'update'
    ])
        ->middleware('permission:aplicaciones.editar-propias')
        ->name('aplicaciones.update');

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR APLICACIÓN
    |--------------------------------------------------------------------------
    */

    Route::delete('/aplicaciones/{aplicacion}', [
        AplicacionController::class,
        'destroy'
    ])
        ->middleware('permission:aplicaciones.eliminar-propias')
        ->name('aplicaciones.destroy');
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| ADMINISTRACIÓN DE APLICACIONES
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'permission:aplicaciones.moderar',
])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/aplicaciones', [
        \App\Http\Controllers\AdminAplicacionController::class,
        'index'
    ])->name('aplicaciones.index');

    Route::get('/aplicaciones/{aplicacion}', [
        \App\Http\Controllers\AdminAplicacionController::class,
        'show'
    ])->name('aplicaciones.show');

    Route::patch('/aplicaciones/{aplicacion}/aprobar', [
        \App\Http\Controllers\AdminAplicacionController::class,
        'aprobar'
    ])->name('aplicaciones.aprobar');

    Route::patch('/aplicaciones/{aplicacion}/rechazar', [
        \App\Http\Controllers\AdminAplicacionController::class,
        'rechazar'
    ])->name('aplicaciones.rechazar');

    Route::patch('/aplicaciones/{aplicacion}/destacar', [
        \App\Http\Controllers\AdminAplicacionController::class,
        'destacar'
    ])->name('aplicaciones.destacar');
});

require __DIR__.'/auth.php';
