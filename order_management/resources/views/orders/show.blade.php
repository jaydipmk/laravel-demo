<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Order Details</h2>
    <div class="card">
        <div class="card-header">
            Order #{{ $order->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Customer: {{ $order->client_name }}</h5>
            <p class="card-text">Sub Total Amount: ${{ number_format($order->sub_total_amount, 2) }}</p>
            <p class="card-text">Discount: ${{ number_format($order->discount, 2) }}</p>
            <p class="card-text">Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
            <p class="card-text">Order Date: {{ $order->created_at->format('Y-m-d') }}</p>

            <h5>Products:</h5>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Total Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($order->product as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->qty }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>${{ number_format($product->total_amount, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
