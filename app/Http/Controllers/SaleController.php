<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['user', 'saleItems.product']);

        if ($customer = $request->input('customer')) {
            $query->whereHas('user', function ($q) use ($customer) {
                $q->where('name', 'like', "%{$customer}%");
            });
        }

        if ($product = $request->input('product')) {
            $query->whereHas('saleItems.product', function ($q) use ($product) {
                $q->where('name', 'like', "%{$product}%");
            });
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->where('sale_date', '>=', $dateFrom);
        }

        if ($dateTo = $request->input('date_to')) {
            $query->where('sale_date', '<=', $dateTo);
        }

        $sales = $query->paginate(10);
        $totalPerPage = $sales->sum('total_amount');

        return view('sales.index', compact('sales', 'totalPerPage'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('sales.create', compact('users', 'products'));
    }

    public function store(StoreSaleRequest $request)
    {
        try {
            DB::beginTransaction();

            $sale = Sale::create([
                'user_id' => $request->user_id,
                'sale_date' => $request->sale_date,
                'total_amount' => calculateSaleTotal($request->items),
            ]);

            foreach ($request->items as $item) {
                $sale->saleItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['discount'] ?? 0,
                    'subtotal' => ($item['quantity'] * $item['price']) - ($item['discount'] ?? 0),
                ]);
            }

            if ($request->note) {
                $sale->notes()->create(['content' => $request->note]);
            }

            DB::commit();

            return response()->json(['message' => 'Sale created successfully', 'sale_id' => $sale->id], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create sale'], 500);
        }
    }

    public function trash()
    {
        $sales = Sale::onlyTrashed()->with(['user', 'saleItems.product'])->paginate(10);
        return view('sales.trash', compact('sales'));
    }

    public function restore($id)
    {
        $sale = Sale::onlyTrashed()->findOrFail($id);
        $sale->restore();
        $sale->saleItems()->onlyTrashed()->restore();
        return redirect()->route('sales.trash')->with('success', 'Sale restored successfully');
    }

    public function getProductPrice($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['price' => $product->price]);
    }
}
