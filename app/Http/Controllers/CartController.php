<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Tampilkan halaman keranjang
     */
    public function index()
    {
        $cart = $this->cartService->getCart();

        if ($cart) {
            $cart->load([
                'items.product.category'
            ]);
        }

        return view('cart.index', compact('cart'));
    }

    /**
     * Tambah produk ke keranjang
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ]);

        try {
            $product = Product::findOrFail($request->product_id);

            $this->cartService->addProduct($product, $request->quantity);

            return redirect()
                ->back()
                ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Update jumlah item
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->cartService->updateQuantity($itemId, $request->quantity);

            return redirect()
                ->back()
                ->with('success', 'Keranjang berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Hapus item dari keranjang
     */
    public function remove($itemId)
    {
        try {
            $this->cartService->removeItem($itemId);

            return redirect()
                ->back()
                ->with('success', 'Item berhasil dihapus dari keranjang.');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}
