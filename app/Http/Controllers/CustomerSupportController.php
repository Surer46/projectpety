<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerSupportController extends Controller
{
    public function index()
    {
        return view('atencion_cliente');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Gracias por tu mensaje! Tu folio de atención #' . rand(1000, 9999) . ' ha sido registrado.'
        ]);
    }
}
