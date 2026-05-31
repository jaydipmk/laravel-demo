<!DOCTYPE html>
<html>
<head>
    <title>Order Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Order Management</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Order No</th>
            <th>Customer Name</th>
            <th>Total Amount</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>{{ $order->total_amount }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">View</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
