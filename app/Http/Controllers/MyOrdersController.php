<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyOrdersController extends Controller
{
    /**
     * Display active orders tracking page ("Mis Pedidos").
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'activos'); // activos, preparacion, reparto

        // Query active orders from DB
        $dbOrders = DB::table('orders')
            ->whereIn('status', ['pending', 'in_preparation', 'on_delivery', 'ready'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Convert or enrich DB active orders
        $activeOrders = [];

        foreach ($dbOrders as $o) {
            $items = DB::table('order_items')
                ->where('order_id', $o->id)
                ->get();

            $activeOrders[] = (object)[
                'id' => $o->id,
                'order_number' => $o->order_number ?? ('ORD-' . $o->id),
                'order_type' => $o->order_type ?? 'takeout', // dine_in, takeout, delivery
                'type_label' => $this->getTypeLabel($o->order_type ?? 'takeout'),
                'type_icon' => $this->getTypeIcon($o->order_type ?? 'takeout'),
                'status' => $o->status ?? 'in_preparation', // pending, in_preparation, on_delivery, ready
                'status_label' => $this->getStatusLabel($o->status ?? 'in_preparation'),
                'status_color' => $this->getStatusColor($o->status ?? 'in_preparation'),
                'progress_percentage' => $this->getProgressPercentage($o->status ?? 'in_preparation'),
                'table_name' => property_exists($o, 'table_name') ? $o->table_name : null,
                'customer_name' => $o->customer_name ?? 'Cliente',
                'delivery_address' => property_exists($o, 'delivery_address') && $o->delivery_address ? $o->delivery_address : ($o->order_type === 'delivery' ? 'Dirección Registrada de Entrega' : null),
                'estimated_minutes' => 15,
                'driver_name' => property_exists($o, 'driver_name') && $o->driver_name ? $o->driver_name : ($o->order_type === 'delivery' ? 'Repartidor de Sucursal' : null),
                'driver_phone' => property_exists($o, 'driver_phone') && $o->driver_phone ? $o->driver_phone : '',
                'driver_vehicle' => property_exists($o, 'driver_vehicle') && $o->driver_vehicle ? $o->driver_vehicle : 'Vehículo Oficial PETY',
                'total_amount' => $o->total_amount ?? 0,
                'created_at' => $o->created_at ? \Carbon\Carbon::parse($o->created_at)->format('H:i \h\r\s') : now()->format('H:i \h\r\s'),
                'items' => $items
            ];
        }

        // Filter orders by subtab
        $filteredOrders = array_filter($activeOrders, function ($ord) use ($tab) {
            if ($tab === 'preparacion') {
                return $ord->status === 'in_preparation' || $ord->status === 'pending';
            }
            if ($tab === 'reparto') {
                return $ord->order_type === 'delivery' && ($ord->status === 'on_delivery' || $ord->status === 'in_preparation');
            }
            return true; // 'activos'
        });

        $stats = (object)[
            'total_active' => count($activeOrders),
            'in_preparation' => count(array_filter($activeOrders, fn($o) => $o->status === 'in_preparation' || $o->status === 'pending')),
            'on_delivery' => count(array_filter($activeOrders, fn($o) => $o->order_type === 'delivery' && $o->status === 'on_delivery')),
            'ready' => count(array_filter($activeOrders, fn($o) => $o->status === 'ready'))
        ];

        return view('pedidos.index', compact('filteredOrders', 'tab', 'stats'));
    }

    private function getTypeLabel($type)
    {
        switch ($type) {
            case 'delivery': return 'Entrega a Domicilio';
            case 'dine_in': return 'Consumo en Restaurante';
            case 'takeout': return 'Para Llevar';
            default: return 'Pedido';
        }
    }

    private function getTypeIcon($type)
    {
        switch ($type) {
            case 'delivery': return 'two_wheeler';
            case 'dine_in': return 'table_restaurant';
            case 'takeout': return 'shopping_bag';
            default: return 'receipt_long';
        }
    }

    private function getStatusLabel($status)
    {
        switch ($status) {
            case 'pending': return 'Recibido / Confirmando';
            case 'in_preparation': return 'En Preparación (Cocina)';
            case 'on_delivery': return 'En Reparto / En Camino';
            case 'ready': return '¡Listo para Entrega!';
            default: return 'En proceso';
        }
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'pending': return '#94a3b8';
            case 'in_preparation': return '#f59e0b';
            case 'on_delivery': return '#3b82f6';
            case 'ready': return '#10b981';
            default: return '#c79c5e';
        }
    }

    private function getProgressPercentage($status)
    {
        switch ($status) {
            case 'pending': return 20;
            case 'in_preparation': return 55;
            case 'on_delivery': return 80;
            case 'ready': return 100;
            default: return 50;
        }
    }

    /**
     * Advance order status in real time.
     */
    public function updateStatus(Request $request, $id)
    {
        $order = DB::table('orders')->where('id', $id)->first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado.'], 404);
        }

        $nextStatus = 'completed';
        if ($order->status === 'pending') {
            $nextStatus = 'in_preparation';
        } elseif ($order->status === 'in_preparation') {
            $nextStatus = ($order->order_type === 'delivery') ? 'on_delivery' : 'ready';
        } elseif ($order->status === 'on_delivery' || $order->status === 'ready') {
            $nextStatus = 'completed';
        }

        DB::table('orders')->where('id', $id)->update([
            'status' => $nextStatus,
            'updated_at' => now(),
        ]);

        $message = ($nextStatus === 'completed') 
            ? '¡Pedido finalizado con éxito! Ha sido archivado a tu historial de Mis Compras.' 
            : 'Estado actualizado a: ' . $this->getStatusLabel($nextStatus);

        return response()->json([
            'success' => true,
            'new_status' => $nextStatus,
            'message' => $message
        ]);
    }
}
