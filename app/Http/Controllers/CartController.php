<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CartController extends Controller
{
    public function create(Request $request)
    {
        $carts = Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();
        $cartTotal = $carts->count();
        $request->merge(['cartTotal'=>$cartTotal]);

        return view('cart.cart',[
            "title" => "My Cart",
            "active" => "cart",
            "carts" => $carts
        ]);
    }

    public function store(Request $request,Book $book)
    {   
        $validateData = $request->validate([
            'quantity' => 'required'
        ]);
        Cart::create([
            'user_id' => auth()->user()->id,
            'book_id' => $book->id,
            'quantity' => $request->quantity
        ]);
 
        $carts = Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();
        
        return view('cart.cart',[
            "title" => "My Cart",
            "active" => "cart",
            "carts" => $carts
        ]);
    }

    public function checkout(Request $request)
    {
        $validateData = $request->validate([
            'grandTotal' => 'required'
        ]);
        $carts = Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();

        return view('cart.checkout', [
                "title" => "CheckOut",
                "active" => "cart",
                "carts" => $carts,
                'grandTotal' => $request->grandTotal
            ]);
            // return $request->grandTotal;
    }
}
