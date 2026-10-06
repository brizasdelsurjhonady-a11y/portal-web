<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | PERMISOS DEL SISTEMA
        |--------------------------------------------------------------------------
        */

        $permisos = [
            'aplicaciones.ver',
            'aplicaciones.crear',
            'aplicaciones.editar-propias',
            'aplicaciones.eliminar-propias',
            'aplicaciones.moderar',
            'aplicaciones.aprobar',
            'aplicaciones.rechazar',
            'categorias.gestionar',
            'usuarios.gestionar',
            'estadisticas.ver',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ROL ADMINISTRADOR
        |--------------------------------------------------------------------------
        */

        $administrador = Role::firstOrCreate([
            'name' => 'administrador',
            'guard_name' => 'web',
        ]);

        $administrador->syncPermissions($permisos);

        /*
        |--------------------------------------------------------------------------
        | ROL ESTUDIANTE
        |--------------------------------------------------------------------------
        */

        $estudiante = Role::firstOrCreate([
            'name' => 'estudiante',
            'guard_name' => 'web',
        ]);

        $estudiante->syncPermissions([
            'aplicaciones.ver',
            'aplicaciones.crear',
            'aplicaciones.editar-propias',
            'aplicaciones.eliminar-propias',
        ]);
    }
}
