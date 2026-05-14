<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{
    private const DELIVERY_PRICE = 300;

    private const PICKUP_ADDRESS = 'г. Ижевск, Пушкинская 268';

    public function index(Request $request): View
    {
        $items = $this->cartItems($request);
        $itemsTotal = $items->sum('line_total');

        return view('cart.index', [
            'items' => $items,
            'total' => $itemsTotal,
            'itemsTotal' => $itemsTotal,
            'deliveryPrice' => self::DELIVERY_PRICE,
            'pickupAddress' => self::PICKUP_ADDRESS,
            'user' => $request->user(),
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        if ($product->stock < 1) {
            return back()->withErrors(['cart' => 'Товар закончился на складе.']);
        }

        $quantityToAdd = (int) ($validated['quantity'] ?? 1);
        $user = $request->user();

        $cartItem = CartItem::query()->firstOrNew([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $currentQuantity = (int) ($cartItem->quantity ?? 0);
        $cartItem->quantity = min($currentQuantity + $quantityToAdd, $product->stock);
        $cartItem->save();

        return back()->with('status', 'Товар добавлен в корзину.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:20'],
        ]);

        $cartItem = CartItem::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if (! $cartItem) {
            return back();
        }

        $newQuantity = min((int) $validated['quantity'], $product->stock);
        if ($newQuantity < 1) {
            $cartItem->delete();
        } else {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        }

        return back()->with('status', 'Корзина обновлена.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        CartItem::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('status', 'Товар удален из корзины.');
    }

    public function clear(Request $request): RedirectResponse
    {
        CartItem::query()
            ->where('user_id', $request->user()->id)
            ->delete();

        return back()->with('status', 'Корзина очищена.');
    }

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

    private function cartItems(Request $request)
    {
        return $this->cartItemsQuery($request)
            ->get()
            ->map(function (CartItem $item): array {
                $product = $item->product;
                $price = (float) ($product?->price ?? 0);
                $quantity = (int) $item->quantity;

                return [
                    'product_id' => $item->product_id,
                    'name' => $product?->name ?? 'Товар удален',
                    'image' => $product?->image,
                    'price' => $price,
                    'quantity' => $quantity,
                    'stock' => (int) ($product?->stock ?? 0),
                    'line_total' => $price * $quantity,
                ];
            });
    }

    private function cartItemsQuery(Request $request)
    {
        return CartItem::query()
            ->with('product')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at');
    }
}
