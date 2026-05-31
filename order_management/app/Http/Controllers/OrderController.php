<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'total_amount' => $request->total_amount
        ]);

        foreach ($request->products as $product) {
            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'amount' => $product['amount'],
                'total_price' => $product['total_price']
            ]);
        }

        return response()->json(['success' => 'Order added successfully']);
    }

    public function show($id)
    {
        $order = Order::with('customer', 'products')->find($id);
//        $order = Order::with( 'products')->find($id);
//        return ($order);
        return view('orders.show', compact('order'));
    }
}
