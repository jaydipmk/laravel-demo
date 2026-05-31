<!DOCTYPE html>
<html>
<head>
    <title>Add Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Add Order</h2>
    <form id="orderForm">
        @csrf
        <div class="mb-3">
            <label for="customer" class="form-label">Customer</label>
            <select id="customer" name="customer_id" class="form-select" required>
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="products">
            <div class="product row mb-2">
                <div class="col-md-3">
                    <select name="products[0][product_id]" class="form-select product-select" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="products[0][quantity]" class="form-control quantity-input" placeholder="Qty" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="products[0][amount]" class="form-control amount-input" placeholder="Amt" readonly>
                </div>
                <div class="col-md-2">
                    <input type="number" name="products[0][total_price]" class="form-control total-price-input" placeholder="Total" readonly>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                </div>
            </div>
        </div>

        <button type="button" id="addProductBtn" class="btn btn-primary mb-3">Add More</button>

        <div class="mb-3">
            <label for="totalAmount" class="form-label">Total</label>
            <input type="text" id="totalAmount" name="total_amount" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        let productIndex = 1;

        function calculateTotalAmount() {
            let totalAmount = 0;
            $('.total-price-input').each(function() {
                totalAmount += parseFloat($(this).val()) || 0;
            });
            $('#totalAmount').val(totalAmount.toFixed(2));
        }

        function calculateRowTotal(row) {
            const price = row.find('.product-select option:selected').data('price') || 0;
            const quantity = row.find('.quantity-input').val() || 0;
            const amount = price * quantity;
            row.find('.amount-input').val(price);
            row.find('.total-price-input').val(amount.toFixed(2));
            calculateTotalAmount();
        }

        $('#addProductBtn').on('click', function() {
            const productTemplate = `
                <div class="product row mb-2">
                    <div class="col-md-3">
                        <select name="products[${productIndex}][product_id]" class="form-select product-select" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" placeholder="Qty" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="products[${productIndex}][amount]" class="form-control amount-input" placeholder="Amt" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="products[${productIndex}][total_price]" class="form-control total-price-input" placeholder="Total" readonly>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-product">Remove</button>
                    </div>
                </div>
            `;
            $('#products').append(productTemplate);
            productIndex++;
        });

        $('#products').on('click', '.remove-product', function() {
            $(this).closest('.product').remove();
            calculateTotalAmount();
        });

        $('#products').on('change', '.product-select, .quantity-input', function() {
            const row = $(this).closest('.product');
            calculateRowTotal(row);
        });

        $('#orderForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('orders.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert('Order added successfully');
                    window.location.href = "{{ route('orders.index') }}";
                },
                error: function(response) {
                    alert('Error adding order');
                }
            });
        });
    });
</script>
</body>
</html>
