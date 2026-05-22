<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $recentOrders = Order::query()
            ->with('user:id,name')
            ->latest()
            ->limit(6)
            ->get();

        $pendingReviews = Review::query()
            ->with(['product:id,name,slug', 'user:id,name'])
            ->where('status', Review::STATUS_PENDING)
            ->latest()
            ->limit(6)
            ->get();

        return view('admin.dashboard', [
            'products' => Product::query()->with(['category', 'collection'])->latest()->limit(8)->get(),
            'stats' => [
                'products' => Product::query()->count(),
                'users' => User::query()->count(),
                'admins' => User::query()->where('role', User::ROLE_ADMIN)->count(),
            ],
            'totalRevenue' => (float) Order::query()
                ->where('status', '!=', 'cancelled')
                ->sum('total'),
            'totalOrders' => Order::query()->count(),
            'pendingReviewsCount' => Review::query()
                ->where('status', Review::STATUS_PENDING)
                ->count(),
            'averageApprovedRating' => (float) (Review::query()
                ->where('status', Review::STATUS_APPROVED)
                ->avg('rating') ?? 0),
            'recentOrders' => $recentOrders,
            'pendingReviews' => $pendingReviews,
        ]);
    }
}
