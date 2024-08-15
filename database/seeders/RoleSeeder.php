<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $permisos = Permission::create(['name' => 'crear']);
        $permisos = Permission::create(['name' => 'editar']);
        $permisos = Permission::create(['name' => 'eliminar']);
        
        $rol = Role::create(['name' => 'Administrador']);
        $rol->givePermissionTo(Permission::all());
        $item = User::find(1);
        $item->syncRoles($rol->id);
    }
}
