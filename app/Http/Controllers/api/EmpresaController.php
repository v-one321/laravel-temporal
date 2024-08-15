<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = Empresa::first();
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /*    
            $table->string('nombre', 50);
            $table->string('pagina_web', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('logo')->nullable();
            $table->string('telefono_1', 30);
            $table->string('telefono_2', 30)->nullable();
    */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|max:50",
            "pagina_web" => "required|max:100",
            "email" => "required|email",
            "telefono_1" => "required|max:30",
            "telefono_2" => "max:30",
        ]);
        $item = Empresa::first();
        $item->nombre = $request->nombre;
        $item->pagina_web = $request->pagina_web;
        $item->email = $request->email;
        $item->telefono_1 = $request->telefono_1;
        $item->telefono_2 = $request->telefono_2;
        $item->logo = $request->logo;
        $item->save();
        return response()->json(["mensaje" => "Datos modificados", "datos" => $item], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
