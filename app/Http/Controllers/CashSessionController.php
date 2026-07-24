<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\RestaurantTable;

class CashSessionController extends Controller
{
    /**
     * Shows the cash management dashboard and table reservation system
     */
    public function index()
    {
        $userId = 1; // Simulated auth user

        $activeSession = DB::table('cash_sessions')
            ->where('user_id', $userId)
            ->where('status', 'open')
            ->first();

        $register = DB::table('cash_registers')->where('is_active', 1)->first();

        // Calculate expected amount if there's an active session
        $expectedAmount = 0;
        $totalSales = 0;
        $totalCash = 0;

        if ($activeSession) {
            $expectedAmount = $activeSession->opening_amount;
            
            // Get all sales for this session
            $sales = DB::table('payments')
                ->join('orders', 'payments.order_id', '=', 'orders.id')
                ->where('orders.cash_session_id', $activeSession->id)
                ->where('orders.status', 'completed')
                ->get();
                
            foreach ($sales as $sale) {
                $totalSales += $sale->amount_paid;
                if ($sale->payment_method === 'cash') {
                    $totalCash += $sale->amount_paid;
                }
            }
            
            $expectedAmount += $totalCash;
        }

        // Restaurant tables & active reservations
        $tables = RestaurantTable::orderBy('id')->get();
        $reservations = RestaurantTable::where('status', 'reservada')->orderBy('updated_at', 'desc')->get();

        return view('cash.index', compact('activeSession', 'register', 'expectedAmount', 'totalSales', 'totalCash', 'tables', 'reservations'));
    }

    /**
     * Opens a new cash session
     */
    public function open(Request $request)
    {
        try {
            $userId = 1; // Simulated auth user
            $registerId = $request->input('cash_register_id', 1);
            $openingAmount = $request->input('opening_amount', 0);

            // Verify no open session exists for this user
            $existing = DB::table('cash_sessions')
                ->where('user_id', $userId)
                ->where('status', 'open')
                ->first();

            if ($existing) {
                return response()->json(['success' => false, 'message' => 'Ya tienes una caja abierta.'], 400);
            }

            $sessionId = DB::table('cash_sessions')->insertGetId([
                'cash_register_id' => $registerId,
                'user_id' => $userId,
                'opening_amount' => $openingAmount,
                'status' => 'open',
                'opened_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['success' => true, 'session_id' => $sessionId, 'message' => 'Caja abierta correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error opening cash session: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al abrir caja.'], 500);
        }
    }

    /**
     * Closes the active cash session
     */
    public function close(Request $request)
    {
        try {
            $userId = 1; // Simulated auth user
            $closingAmount = $request->input('closing_amount', 0); // Declared by cashier

            $activeSession = DB::table('cash_sessions')
                ->where('user_id', $userId)
                ->where('status', 'open')
                ->first();

            if (!$activeSession) {
                return response()->json(['success' => false, 'message' => 'No tienes una caja abierta.'], 400);
            }

            // Calculate exact expected amount again
            $expectedAmount = $activeSession->opening_amount;
            $cashSales = DB::table('payments')
                ->join('orders', 'payments.order_id', '=', 'orders.id')
                ->where('orders.cash_session_id', $activeSession->id)
                ->where('orders.status', 'completed')
                ->where('payments.payment_method', 'cash')
                ->sum('payments.amount_paid');
            
            $expectedAmount += $cashSales;
            $difference = $closingAmount - $expectedAmount;

            DB::table('cash_sessions')
                ->where('id', $activeSession->id)
                ->update([
                    'closing_amount' => $closingAmount,
                    'expected_amount' => $expectedAmount,
                    'difference' => $difference,
                    'status' => 'closed',
                    'closed_at' => now(),
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true, 
                'message' => 'Corte realizado.', 
                'difference' => $difference
            ]);
        } catch (\Exception $e) {
            Log::error('Error closing cash session: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al cerrar caja.'], 500);
        }
    }

    /**
     * Reserves a table
     */
    public function reserveTable(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:restaurant_tables,id',
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:50',
            'reservation_time' => 'required|string',
            'party_size' => 'required|integer|min:1',
        ]);

        $table = RestaurantTable::findOrFail($request->input('table_id'));
        $table->update([
            'status' => 'reservada',
            'customer_name' => $request->input('customer_name'),
            'customer_phone' => $request->input('customer_phone'),
            'reservation_time' => $request->input('reservation_time'),
            'party_size' => $request->input('party_size'),
            'notes' => $request->input('notes'),
        ]);

        return redirect()->route('caja')->with('success', 'Mesa ' . $table->table_number . ' reservada con éxito.');
    }

    /**
     * Cancels a table reservation
     */
    public function cancelReservation($id)
    {
        $table = RestaurantTable::findOrFail($id);
        $table->update([
            'status' => 'libre',
            'customer_name' => null,
            'customer_phone' => null,
            'reservation_time' => null,
            'party_size' => null,
            'notes' => null,
        ]);

        return redirect()->route('caja')->with('success', 'Reserva cancelada correctamente.');
    }

    /**
     * Occupies a table
     */
    public function occupyTable($id)
    {
        $table = RestaurantTable::findOrFail($id);
        $table->update([
            'status' => 'ocupada',
        ]);

        return redirect()->route('caja')->with('success', 'Mesa ' . $table->table_number . ' marcada como ocupada.');
    }

    /**
     * Releases an occupied or reserved table
     */
    public function releaseTable($id)
    {
        $table = RestaurantTable::findOrFail($id);
        $table->update([
            'status' => 'libre',
            'customer_name' => null,
            'customer_phone' => null,
            'reservation_time' => null,
            'party_size' => null,
            'notes' => null,
        ]);

        return redirect()->route('caja')->with('success', 'Mesa ' . $table->table_number . ' liberada.');
    }
}
