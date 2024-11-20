<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Mostrar el carrito
    public function showCart()
    {
        $cart = session()->get('cart', []); // Obtener los productos del carrito
        return view('cart.index', compact('cart'));
    }

    // Agregar al carrito
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        // Si el producto ya está en el carrito, incrementar la cantidad
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            // Si no está, agregar al carrito
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // Vaciar el carrito
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.show')->with('success', 'Cart cleared!');
    }
}
