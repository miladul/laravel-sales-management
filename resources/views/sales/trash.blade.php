@extends('layouts.app')

@section('title', 'Trash - Sales')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Deleted Sales</h1>
        <table class="w-full border-collapse">
            <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Customer</th>
                <th class="border p-2">Date</th>
                <th class="border p-2">Total</th>
                <th class="border p-2">Actions</th>
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
                        <form action="{{ route('sales.restore', $sale->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded" onclick="return confirm('Are you sure you want to restore this sale?')">Restore</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $sales->links() }}
        </div>
        <a href="{{ route('sales.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Back to Sales</a>
    </div>
@endsection
