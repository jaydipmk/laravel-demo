<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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

    public function dashboard1()
    {
        $orders = Order::with('items')->latest()->get();
        return view('admin.orders-dashboard', compact('orders'));
    }

     public function dashboard()
    {
        return view('admin.orders-dashboard1');
    }

    public function getOrdersData()
    {
        $orders = Order::latest();

        return DataTables::of($orders)
            ->addColumn('total_amount_formatted', function ($order) {
                return number_format($order->total_amount, 2);
            })
            ->addColumn('status_label', function ($order) {
                return ucfirst($order->status);
            })
            ->addColumn('created_at_formatted', function ($order) {
                return $order->created_at->format('d M Y, h:i A');
            })
            ->rawColumns([])
            ->make(true);
    }
}
