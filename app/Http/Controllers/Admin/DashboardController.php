<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'products' => Product::query()->latest()->limit(8)->get(),
            'users' => User::query()->orderBy('name')->get(),
            'stats' => [
                'products' => Product::query()->count(),
                'users' => User::query()->count(),
                'admins' => User::query()->where('role', User::ROLE_ADMIN)->count(),
            ],
        ]);
    }
}
