<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Orders Dashboard</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CDN -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <h3 class="mb-4">Admin Orders Dashboard</h3>

    <!-- Live Incoming Orders -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            Live Incoming Orders <span class="badge bg-success">Real-time</span>
        </div>
        <ul id="liveOrdersList" class="list-group list-group-flush">
            <li class="list-group-item text-muted" id="liveEmptyMsg">Waiting for new orders...</li>
        </ul>
    </div>

    <!-- All Orders Table -->
    <div class="card">
        <div class="card-header bg-secondary text-white">All Orders</div>
        <div class="card-body">
            <table id="ordersTable" class="table table-striped w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Placed At</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Pusher JS -->
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

<script>
$(function () {
   const table = $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
         ajax: {
        url: '{{ route('admin.orders.data') }}',
        type: 'POST',
        data: function (d) {
            d._token = '{{ csrf_token() }}';
        }
    },
        order: [[0, 'desc']],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'total_amount_formatted', name: 'total_amount' },
            { data: 'status_label', name: 'status' },
            { data: 'created_at_formatted', name: 'created_at' },
        ]
    });

    Pusher.logToConsole = true;

const pusher = new Pusher('{{ config('broadcasting.connections.reverb.key') }}', {
    wsHost: '127.0.0.1',
    wsPort: 8080,
    forceTLS: false,
    enabledTransports: ['ws'],
    cluster: '', // required by pusher-js constructor, unused by Reverb
   // authEndpoint: '/broadcasting/auth',
   // auth: {
       // headers: {
    //        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //    }
//}
});

const channel = pusher.subscribe('admin.orders');

    channel.bind('OrderPlaced', function (data) {

        // 1. Remove "waiting" placeholder
        $('#liveEmptyMsg').remove();

        // 2. Push to top of the live feed
        const itemsList = data.items.map(i => `${i.item_name} (x${i.quantity})`).join(', ');
        const liveItem = `
            <li class="list-group-item">
                <strong>${data.customer_name}</strong> — ${data.total_amount}
                <br><small class="text-muted">${itemsList}</small>
                <br><small class="text-muted">${data.created_at}</small>
            </li>`;
        $('#liveOrdersList').prepend(liveItem);

        // 3. Add to the DataTable instantly
         table.ajax.reload(null, false);

        // 4. Notify the admin
        Swal.fire({
            icon: 'info',
            title: 'New Order Received!',
            text: `${data.customer_name} just placed an order.`,
            timer: 2500,
            showConfirmButton: false
        });
    });
});
</script>

</body>
</html>
