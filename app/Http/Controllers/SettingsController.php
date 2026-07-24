<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        // 1. Perfil Mock
        $perfil = (object)[
            'Name' => auth()->check() ? auth()->user()->name : 'Oscar Dueño',
            'Username' => auth()->check() ? auth()->user()->email : 'oscar.dueno',
            'Role' => auth()->check() ? auth()->user()->role : 'dueño',
            'IsAdmin' => true,
            'AvatarUrl' => '/img/logo-compacto(1).png', // Fallback avatar
            'SessionId' => 'sess_' . substr(md5(rand()), 0, 12),
        ];

        // 2. Ajustes de Restaurante Mock
        $ajustes = (object)[
            'RestaurantName' => 'Cafeteria PETY',
            'RestaurantPhone' => '444-555-0101',
            'RestaurantEmail' => 'contacto@pety.mx',
            'RestaurantAddress' => 'Av. Constitución 120, SLP',
            'DefaultTaxRate' => 16.00,
        ];

        // 3. Impuestos Mock
        $impuestos = [
            (object)['Nombre' => 'IVA General', 'Tipo' => 'IVA', 'Porcentaje' => 16.0, 'IncluidoEnPrecio' => true, 'Activo' => true],
            (object)['Nombre' => 'IEPS Bebidas', 'Tipo' => 'IEPS', 'Porcentaje' => 8.0, 'IncluidoEnPrecio' => false, 'Activo' => false],
            (object)['Nombre' => 'Sin Impuesto', 'Tipo' => 'Exento', 'Porcentaje' => 0.0, 'IncluidoEnPrecio' => true, 'Activo' => true],
        ];

        $tabActiva = $request->query('tab', 'perfil');

        return view('settings', compact('perfil', 'ajustes', 'impuestos', 'tabActiva'));
    }
}
