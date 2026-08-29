<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
    {

        $validated = $request->validated();

        $order = DB::transaction(function () use ($validated) {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'total_amount'  => $validated['total_amount'],
                'status'        => 'pending',
            ]);

            foreach ($validated['items'] as $item) {
                $order->items()->create([
                    'item_name' => $item['item_name'],
                    'quantity'  => $item['quantity'],
                ]);
            }

            return $order;
        });

        broadcast(new OrderPlaced($order))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order'   => $order->load('items'),
        ]);
    }

    public function dashboard()
    {
        $orders = Order::with('items')->latest()->get();
        return view('admin.orders-dashboard', compact('orders'));
    }
}
