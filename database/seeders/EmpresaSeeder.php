<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
            $table->string('nombre', 50);
            $table->string('pagina_web', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('logo')->nullable();
            $table->string('telefono_1', 30);
            $table->string('telefono_2', 30)->nullable();
        */
        $item = new Empresa();
        $item->nombre = 'Empresa';
        $item->pagina_web = 'www.empresa.com';
        $item->email = 'empresa@mail.com';
        $item->telefono_1 = '77777777';
        $item->telefono_2 = '77777777';
        $item->save();
    }
}
