<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRoleRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::query()->create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'phone' => $request->string('phone')->toString() ?: null,
            'password' => $request->string('password')->toString(),
            'role' => $request->boolean('is_admin') ? User::ROLE_ADMIN : User::ROLE_USER,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Пользователь создан.');
    }

    public function updateRole(UpdateUserRoleRequest $request, User $user): RedirectResponse
    {
        if ($user->is($request->user()) && $request->input('role') !== User::ROLE_ADMIN) {
            return back()->withErrors([
                'role' => 'Нельзя снять права администратора у своей учётной записи.',
            ]);
        }

        $user->update(['role' => $request->input('role')]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Роль пользователя обновлена.');
    }
}
