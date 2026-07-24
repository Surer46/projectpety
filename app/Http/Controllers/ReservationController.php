<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RestaurantTable;
use App\Models\RestaurantArea;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        // Cargar áreas físicas activas con sus mesas asociadas ordenadas
        $areas = RestaurantArea::where('is_active', true)
                    ->with(['tables' => fn($q) => $q->orderBy('table_number')])
                    ->orderBy('sort_order')
                    ->get();

        // Mesas generales para select (incluye información de área)
        $tables = RestaurantTable::with('area')->orderBy('table_number')->get();

        // Reservaciones activas e historial
        $activeReservations = Reservation::with(['table', 'area'])
                    ->where('status', 'confirmed')
                    ->orderBy('reservation_date', 'asc')
                    ->orderBy('reservation_time', 'asc')
                    ->get();

        return view('reservaciones', compact('areas', 'tables', 'activeReservations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id'         => 'required|exists:restaurant_tables,id',
            'customer_name'    => 'required|string|max:150',
            'customer_phone'   => 'required|string|max:50',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|string',
            'party_size'       => 'required|integer|min:1',
        ]);

        $table = RestaurantTable::findOrFail($request->input('table_id'));

        // 1. Crear registro formal en la tabla de historial `reservations`
        $reservation = Reservation::create([
            'restaurant_table_id' => $table->id,
            'area_id'             => $table->area_id,
            'customer_name'       => $request->input('customer_name'),
            'customer_phone'      => $request->input('customer_phone'),
            'reservation_date'    => $request->input('reservation_date'),
            'reservation_time'    => $request->input('reservation_time'),
            'party_size'          => $request->input('party_size'),
            'notes'               => $request->input('notes'),
            'status'              => 'confirmed',
        ]);

        // 2. Actualizar estado en vivo de la mesa
        $table->update([
            'status'           => 'reservada',
            'customer_name'    => $request->input('customer_name'),
            'customer_phone'   => $request->input('customer_phone'),
            'reservation_time' => $request->input('reservation_time'),
            'party_size'       => $request->input('party_size'),
            'notes'            => $request->input('notes'),
        ]);

        return redirect()->route('reservaciones')
            ->with('success', '¡Tu reservación para la ' . $table->table_number . ' ha sido confirmada para el ' . Carbon::parse($request->input('reservation_date'))->format('d/m/Y') . '!');
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'status'       => 'cancelled',
            'cancelled_at' => Carbon::now(),
        ]);

        // Si la mesa asociada sigue asignada a esta reserva, liberarla
        if ($reservation->table) {
            $reservation->table->update([
                'status'           => 'libre',
                'customer_name'    => null,
                'customer_phone'   => null,
                'reservation_time' => null,
                'party_size'       => null,
                'notes'            => null,
            ]);
        }

        return redirect()->route('reservaciones')
            ->with('success', 'La reservación #' . $reservation->id . ' ha sido cancelada y la mesa fue liberada.');
    }
}
