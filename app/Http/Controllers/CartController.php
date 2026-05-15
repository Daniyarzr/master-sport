<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
