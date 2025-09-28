@extends('layouts.app')

@section('title', 'Create Sale')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Create New Sale</h1>
        <form id="saleForm" action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Customer</label>
                <select name="user_id" class="w-full border p-2 rounded">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Sale Date</label>
                <input type="date" name="sale_date" class="w-full border p-2 rounded" required>
            </div>
            <div id="itemsContainer" class="mb-4">
                <h3 class="text-lg font-semibold mb-2">Sale Items</h3>
                <div class="itemRow flex space-x-2 mb-2">
                    <select name="items[0][product_id]" class="productSelect w-1/4 border p-2 rounded" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="items[0][quantity]" class="w-1/4 border p-2 rounded" placeholder="Quantity" min="1" required>
                    <input type="number" name="items[0][price]" class="priceInput w-1/4 border p-2 rounded" placeholder="Price" step="0.01" readonly>
                    <input type="number" name="items[0][discount]" class="w-1/4 border p-2 rounded" placeholder="Discount" step="0.01" value="0">
                </div>
            </div>
            <button type="button" id="addItem" class="bg-blue-500 text-white px-4 py-2 rounded">Add Item</button>
            <div class="mb-4">
                <label class="block text-gray-700">Notes</label>
                <textarea name="note" class="w-full border p-2 rounded"></textarea>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save Sale</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        let itemCount = 1;

        $('#addItem').click(function() {
            const newRow = `
                <div class="itemRow flex space-x-2 mb-2">
                    <select name="items[${itemCount}][product_id]" class="productSelect w-1/4 border p-2 rounded" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
            </select>
            <input type="number" name="items[${itemCount}][quantity]" class="w-1/4 border p-2 rounded" placeholder="Quantity" min="1" required>
                    <input type="number" name="items[${itemCount}][price]" class="priceInput w-1/4 border p-2 rounded" placeholder="Price" step="0.01" readonly>
                    <input type="number" name="items[${itemCount}][discount]" class="w-1/4 border p-2 rounded" placeholder="Discount" step="0.01" value="0">
                    <button type="button" class="removeItem bg-red-500 text-white px-2 py-1 rounded">Remove</button>
                </div>`;
            $('#itemsContainer').append(newRow);
            itemCount++;
        });

        $(document).on('click', '.removeItem', function() {
            $(this).closest('.itemRow').remove();
        });

        $(document).on('change', '.productSelect', function() {
            const productId = $(this).val();
            const priceInput = $(this).closest('.itemRow').find('.priceInput');

            if (productId) {
                $.ajax({
                    url: '{{ route("products.price", ":id") }}'.replace(':id', productId),
                    method: 'GET',
                    success: function(response) {
                        priceInput.val(response.price);
                    },
                    error: function() {
                        alert('Failed to fetch product price');
                    }
                });
            }
        });

        $('#saleForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert('Sale created successfully! Sale ID: ' + response.sale_id);
                    window.location.href = '{{ route("sales.index") }}';
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.error);
                }
            });
        });
    </script>
@endsection
