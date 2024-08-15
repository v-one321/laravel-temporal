<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol = Role::create(['name' => 'vendedor']);
        $rol->syncPermissions([3]);
        $item = new User();
        $item->nombre = 'vladimir';
        $item->email = 'vladimir123@mail.com';
        $item->password = bcrypt('12345678');
        $item->save();
        $item->syncRoles($rol->id);
    }
}
