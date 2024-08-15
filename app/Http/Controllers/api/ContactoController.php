<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\ContactoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function sendEmail(Request $request){
        $request->validate([
            "nombre" => "required",
            "email" => "required|email",
            "mensaje" => "required"
        ]);
        $correo = new ContactoMailable($request->nombre, $request->mensaje);
        Mail::to($request->email)->send($correo);
        return response()->json(["mensaje" => "Mensaje enviado con exito"], 200);
    }
}
