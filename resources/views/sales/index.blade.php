@extends('layouts.app')

@section('title', 'Sales List')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Sales List</h1>
        <form method="GET" class="mb-4">
            <div class="flex space-x-4">
                <input type="text" name="customer" placeholder="Customer Name" class="border p-2 rounded" value="{{ request('customer') }}">
                <input type="text" name="product" placeholder="Product Name" class="border p-2 rounded" value="{{ request('product') }}">
                <input type="date" name="date_from" class="border p-2 rounded" value="{{ request('date_from') }}">
                <input type="date" name="date_to" class="border p-2 rounded" value="{{ request('date_to') }}">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
            </div>
        </form>
        <table class="w-full border-collapse">
            <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Customer</th>
                <th class="border p-2">Date</th>
                <th class="border p-2">Total</th>
                <th class="border p-2">Items</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td class="border p-2">{{ $sale->id }}</td>
                    <td class="border p-2">{{ $sale->user->name }}</td>
                    <td class="border p-2">{{ $sale->sale_date }}</td>
                    <td class="border p-2">{{ $sale->formatted_total }}</td>
                    <td class="border p-2">
                        <ul>
                            @foreach($sale->saleItems as $item)
                                <li>{{ $item->product->name }} (Qty: {{ $item->quantity }}, Price: {{ $item->price }})</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $sales->links() }}
            <p>Total Amount (Page): {{ number_format($totalPerPage, 2) }} BDT</p>
        </div>
        <a href="{{ route('sales.trash') }}" class="bg-yellow-500 text-white px-4 py-2 rounded mt-4 inline-block">View Trash</a>
    </div>
@endsection
