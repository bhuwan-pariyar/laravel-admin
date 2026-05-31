<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\StockTransaction;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Key Statistics
        $totalSkus = Item::count();
        $lowStockCount = Item::where('stock_quantity', '>', 0)
            ->whereColumn('stock_quantity', '<=', 'reorder_level')
            ->count();
        $outOfStockCount = Item::where('stock_quantity', '<=', 0)->count();
        
        $inventoryCostValue = Item::selectRaw('SUM(cost_price * stock_quantity) as total')->value('total') ?? 0;
        $inventoryRetailValue = Item::selectRaw('SUM(selling_price * stock_quantity) as total')->value('total') ?? 0;
        
        $totalSales = Sale::sum('grand_total') ?? 0;
        $totalPurchases = Purchase::sum('grand_total') ?? 0;
        $totalCustomers = Customer::count();

        // 2. Tabulated Lists for Manage Inventory Card
        $lowStockItems = Item::where('stock_quantity', '>', 0)
            ->whereColumn('stock_quantity', '<=', 'reorder_level')
            ->limit(5)
            ->get();

        $outOfStockItems = Item::where('stock_quantity', '<=', 0)
            ->limit(5)
            ->get();

        $overStockItems = Item::orderBy('stock_quantity', 'desc')
            ->limit(5)
            ->get();

        // 3. Recent Activity & Stock Movements
        $stockMovements = StockTransaction::with(['item', 'user'])
            ->latest()
            ->limit(8)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->limit(8)
            ->get();

        // 4. Sales & Purchases Chart Data (Last 7 Days)
        $chartLabels = [];
        $chartSales = [];
        $chartPurchases = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $chartLabels[] = $date->format('M d');

            $daySales = Sale::whereDate('sale_date', $dateString)->sum('grand_total');
            $dayPurchases = Purchase::whereDate('purchase_date', $dateString)->sum('grand_total');

            $chartSales[] = round($daySales, 2);
            $chartPurchases[] = round($dayPurchases, 2);
        }

        return view('dashboard', compact(
            'totalSkus',
            'lowStockCount',
            'outOfStockCount',
            'inventoryCostValue',
            'inventoryRetailValue',
            'totalSales',
            'totalPurchases',
            'totalCustomers',
            'lowStockItems',
            'outOfStockItems',
            'overStockItems',
            'stockMovements',
            'recentActivities',
            'chartLabels',
            'chartSales',
            'chartPurchases'
        ));
    }
}

