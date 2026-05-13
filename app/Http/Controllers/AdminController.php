<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        return view('admin.index', [
            'usersCount' => User::query()->count(),
            'ordersCount' => Order::query()->count(),
            'newOrdersCount' => Order::query()->where('status', 'new')->count(),
            'productsCount' => Product::query()->count(),
            'recentOrders' => Order::query()->with('user')->latest()->limit(8)->get(),
        ]);
    }
}
