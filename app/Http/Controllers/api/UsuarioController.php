<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UsuarioController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed",
            "password_confirmation" => "required|min:8"
        ]);
        try {
            DB::beginTransaction();
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
            $crear = Permission::create(['name' => 'crear api', 'guard_name' => 'sanctum']); //id = 4
            $editar = Permission::create(['name' => 'editar api', 'guard_name' => 'sanctum']);    //id = 5
            $eliminar = Permission::create(['name' => 'eliminar api', 'guard_name' => 'sanctum']);  //id = 6
    
            $rol = Role::create(['name' => 'vendedor api', 'guard_name' => 'sanctum']);
            $rol->syncPermissions([$crear, $eliminar]);
            $item = new User();
            $item->nombre = $request->nombre;
            $item->email = $request->email;
            $item->password = bcrypt($request->password);
            $item->save();
            $item->assignRole($rol);
            DB::commit();
            return response()->json(["mensaje" => "Usuario registrado", "datos" => $item], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["mensaje" => "error: $th"], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = User::find(Auth::id());
        return response()->json($item, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario_id = Auth::id();
        $request->validate([
            "nombre" => "required",
            "email" => "required|email|unique:users,email,$usuario_id",
            "password" => "confirmed"
        ]);
        $item = User::find($usuario_id);
        $item->nombre = $request->nombre;
        $item->email = $request->email;
        if ($request->password != "") {
            $item->password = bcrypt($request->password);
        }
        if ($request->file('imagen')) {
            if($item->imagen_perfil){
                unlink('fotos/'.$item->imagen_perfil);
            }
            $file = $request->file('imagen');
            $nombreImagen = time().'.png';
            $file->move('fotos/', $nombreImagen);
            $item->imagen_perfil = $nombreImagen;
        }
        $item->save();
        return response()->json(["mensaje" => "Registro modificado", "datos" => $item]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = User::find(Auth::id());
        $item->estado = !$item->estado;
        $item->save();
        return response()->json(["mensaje" => "Usuario bloqueado", "datos" =>$item]);
    }
}
