<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $item = Servicios::when($search, function ($query) use ($search){
            $query->where('titulo', 'LIKE', '%'.$search.'%')
                    ->orWhere('descripcion_corta', 'LIKE', "%$search%")
                    ->orWhere('descripcion_larga', 'LIKE', "%$search%");
        })->with('usuario')->paginate(10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "titulo" => "required|max:50",
            "descripcion_corta" => "required|max:100",
        ]);
        $item = new Servicios();
        $item->usuario_id = Auth::id();
        $item->titulo = $request->titulo;
        $item->descripcion_corta = $request->descripcion_corta;
        $item->descripcion_larga = $request->descripcion_larga;        
        if ($request->file('imagen')) {
            if($item->imagen){
                unlink('servicios/'.$item->imagen);
            }
            $file = $request->file('imagen');
            $nombreImagen = time().'.png';
            $file->move('servicios/', $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        if ($item->save()) {
            return response()->json(["mensaje" => "Registro exitoso", "datos" => $item], 200);
        }else{
            return response()->json(["mensaje" => "No se pudo realizar el registro"], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Servicios::find($id);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "titulo" => "required|max:50",
            "descripcion_corta" => "required|max:100",
        ]);
        $item = Servicios::find($id);
        $item->usuario_id = Auth::id();
        $item->titulo = $request->titulo;
        $item->descripcion_corta = $request->descripcion_corta;
        $item->descripcion_larga = $request->descripcion_larga;        
        if ($request->file('imagen')) {
            if($item->imagen){
                unlink('servicios/'.$item->imagen);
            }
            $file = $request->file('imagen');
            $nombreImagen = time().'.png';
            $file->move('servicios/', $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        if ($item->save()) {
            return response()->json(["mensaje" => "Registro exitoso", "datos" => $item], 200);
        }else{
            return response()->json(["mensaje" => "No se pudo realizar el registro"], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Servicios::find($id);
        $item->estado = !$item->estado;
        $item->save();
        if ($item->save()) {
            return response()->json(["mensaje" => "Registro exitoso", "datos" => $item], 200);
        }else{
            return response()->json(["mensaje" => "No se pudo realizar el registro"], 422);
        }
    }
    public function serviciosActivos()
    {
        $item = Servicios::where('estado', true)->get();
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }
}
