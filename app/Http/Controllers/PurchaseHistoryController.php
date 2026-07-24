<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseHistoryController extends Controller
{
    /**
     * Display purchase history ("Mis Compras") for the authenticated user.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'todas'); // todas, completadas, facturadas
        $search = $request->query('search', '');

        // Fetch completed orders from DB
        $dbOrders = DB::table('orders')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        $history = [];

        foreach ($dbOrders as $o) {
            $items = DB::table('order_items')
                ->where('order_id', $o->id)
                ->get();

            $history[] = (object)[
                'id' => $o->id,
                'order_number' => $o->order_number ?? ('ORD-' . $o->id),
                'date_formatted' => $o->created_at ? \Carbon\Carbon::parse($o->created_at)->format('d/M/Y - H:i \h\r\s') : now()->format('d/M/Y - H:i \h\r\s'),
                'order_type' => $o->order_type ?? 'dine_in',
                'type_label' => $this->getTypeLabel($o->order_type ?? 'dine_in'),
                'type_icon' => $this->getTypeIcon($o->order_type ?? 'dine_in'),
                'payment_method' => 'Pago Procesado',
                'payment_icon' => 'credit_card',
                'points_earned' => (int) floor(($o->total_amount ?? 0) / 10),
                'total_amount' => $o->total_amount ?? 0,
                'is_invoiced' => true,
                'rating' => 5,
                'items' => $items
            ];
        }

        // Search filtering
        if (!empty($search)) {
            $history = array_filter($history, function ($ord) use ($search) {
                $searchLower = strtolower($search);
                if (str_contains(strtolower($ord->order_number), $searchLower)) {
                    return true;
                }
                foreach ($ord->items as $it) {
                    if (str_contains(strtolower($it->product_name), $searchLower)) {
                        return true;
                    }
                }
                return false;
            });
        }

        // Subtab filtering
        if ($tab === 'facturadas') {
            $history = array_filter($history, fn($o) => $o->is_invoiced);
        }

        $stats = (object)[
            'total_spent' => array_sum(array_column($history, 'total_amount')),
            'total_orders' => count($history),
            'points_earned' => array_sum(array_column($history, 'points_earned')),
            'favorite_item' => 'Frappé Moka Especial'
        ];

        return view('compras.index', compact('history', 'tab', 'search', 'stats'));
    }

    private function getTypeLabel($type)
    {
        switch ($type) {
            case 'delivery': return 'Entrega a Domicilio';
            case 'dine_in': return 'Consumo en Restaurante';
            case 'takeout': return 'Para Llevar';
            default: return 'Compra';
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
}
