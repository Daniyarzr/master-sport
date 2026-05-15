<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    private const DELIVERY_PRICE = 300;

    private const PICKUP_ADDRESS = 'г. Ижевск, Пушкинская 268';

    public function checkout(Request $request): RedirectResponse
    {
        $items = $this->cartItemsQuery($request)->get();

        if ($items->isEmpty()) {
            return back()->withErrors(['cart' => 'Корзина пуста.']);
        }

        $user = $request->user();

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'customer_phone' => ['required', 'string', 'max:30', Rule::unique('users', 'phone')->ignore($user->id)],
            'delivery_type' => ['required', Rule::in(['pickup', 'delivery'])],
            'delivery_address' => ['nullable', 'required_if:delivery_type,delivery', 'string', 'max:500'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $deliveryType = (string) $validated['delivery_type'];
        $deliveryCost = $deliveryType === 'delivery' ? self::DELIVERY_PRICE : 0;
        $deliveryAddress = $deliveryType === 'delivery'
            ? $validated['delivery_address']
            : self::PICKUP_ADDRESS;

        DB::transaction(function () use ($items, $validated, $user, $deliveryType, $deliveryCost, $deliveryAddress): void {
            $order = Order::query()->create([
                'user_id' => $user->id,
                'status' => 'new',
                'total' => 0,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'delivery_type' => $deliveryType,
                'delivery_cost' => $deliveryCost,
                'delivery_address' => $deliveryAddress,
                'comment' => $validated['comment'] ?? null,
            ]);

            $total = 0;

            foreach ($items as $item) {
                $product = $item->product;
                if (! $product) {
                    throw ValidationException::withMessages([
                        'cart' => 'Один из товаров больше не доступен.',
                    ]);
                }

                if ($item->quantity > $product->stock) {
                    throw ValidationException::withMessages([
                        'cart' => "Недостаточно остатка для товара {$product->name}.",
                    ]);
                }

                $lineTotal = (float) $product->price * (int) $item->quantity;
                $total += $lineTotal;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'quantity' => $item->quantity,
                    'line_total' => $lineTotal,
                ]);

                $product->decrement('stock', $item->quantity);
            }

            $order->update(['total' => $total + $deliveryCost]);

            $user->update([
                'name' => $validated['customer_name'],
                'email' => $validated['customer_email'],
                'phone' => $validated['customer_phone'],
            ]);

            CartItem::query()->where('user_id', $user->id)->delete();
        });

        return redirect()->route('dashboard')->with('status', 'Заказ оформлен.');
    }

    private function cartItemsQuery(Request $request)
    {
        return CartItem::query()
            ->with('product')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at');
    }
}
