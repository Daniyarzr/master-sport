<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->input('from', now()->subMonth()->startOfDay());
        $to = $request->input('to', now()->endOfDay());

        $sales = Order::selectRaw('DATE(created_at) as date, COUNT(*) as orders_count, SUM(total) as revenue')
            ->whereBetween('created_at', [$from, $to])
            ->where('status', '!=', 'cancelled')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'), DB::raw('SUM(order_items.price * order_items.quantity) as revenue'))
            ->whereBetween('orders.created_at', [$from, $to])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return view('admin.statistics.sales', compact('sales', 'topProducts', 'from', 'to'));
    }

    public function activity(Request $request)
    {
        $from = $request->input('from', now()->subMonth()->startOfDay());
        $to = $request->input('to', now()->endOfDay());

        $registrations = User::whereBetween('created_at', [$from, $to])->count();
        $reviewsCount = Review::whereBetween('created_at', [$from, $to])->count();
        $ordersCount = Order::whereBetween('created_at', [$from, $to])->count();

        $dailyActivity = User::selectRaw('DATE(created_at) as date, COUNT(*) as new_users')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.statistics.activity', compact(
            'registrations', 'reviewsCount', 'ordersCount', 'dailyActivity', 'from', 'to'
        ));
    }

    public function dashboard()
    {
        return view('admin.statistics.dashboard', [
            'totalRevenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'totalOrders' => Order::count(),
            'totalUsers' => User::count(),
            'pendingReviews' => Review::where('status', 'pending')->count(),
            'avgRating' => Review::where('status', 'approved')->avg('rating') ?? 0,
            'recentOrders' => Order::with('user')->latest()->limit(5)->get(),
            'recentReviews' => Review::with(['product', 'user'])->where('status', 'pending')->latest()->limit(5)->get(),
        ]);
    }
}