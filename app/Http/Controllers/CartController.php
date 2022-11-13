<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Services\Midtrans\CreateSnapTokenService;

class CartController extends Controller
{
    public function create(Request $request)
    {
        $carts = Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();
        $cartTotal = $carts->count();
        Session::put('cartTotal',$cartTotal);
        // Cart::cartTotal();
        
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
        $cartTotal = $carts->count();
        Session::put('cartTotal',$cartTotal);
        // Cart::cartTotal();
        
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
        $cartTotal = $carts->count();
        Session::put('cartTotal',$cartTotal);
        // Cart::cartTotal();
        
        return view('cart.checkout', [
                "title" => "CheckOut",
                "active" => "cart",
                "carts" => $carts,
                'grandTotal' => $request->grandTotal
            ]);
            // return $request->grandTotal;
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'quantity' => 'required',
        ]);
                
        if($validator->fails()){
            return response()->json([
            'status' => 400,
            'errors' =>$validator->messages()
            ]);
        } else {
            $cart = Cart::findOrFail($id);
            if($cart){
                $cart->quantity = $request->quantity;
                $cart->update();
                return response()->json([
                'status' =>200,
                'message' => 'Product Updated successfully'
                ]);
                $carts = Cart::where('user_id', auth()->user()->id);
                $cartTotal = $carts->count();
                Session::put('cartTotal',$cartTotal);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Product not found'
                ]);
            }
        }
    }

    public function destroy($id){
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return response()->json([
            'status' =>200,
            'message' => 'Product Deleted successfully'
        ]);
        $carts = Cart::where('user_id', auth()->user()->id);
        $cartTotal = $carts->count();
        Session::put('cartTotal',$cartTotal);
    }


    public function order(Request $request, Order $order)
    {
        $validateData = $request->validate([
            'grandTotal' => 'required'
        ]);
        
        $carts = Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();
        
        foreach ($carts as $cart){
            Order::create([
                'user_id' => auth()->user()->id,
                'book_id' => $cart->id,
                'quantity' => $cart->quantity,
                'price' => $cart->book->price,
                'number' => Str::random(8),
                'payment_status' => 1
            ]);
            $cart->delete();
        }
        $order = Order::where(['user_id' => auth()->user()->id, 'payment_status' => 1])->first();
        $orders = Order::where(['user_id' => auth()->user()->id, 'payment_status' => 1])->get();
        
        $carts = Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();
        $cartTotal = $carts->count();
        Session::put('cartTotal',$cartTotal);
        
        $snapToken = $order->snap_token;
        if (empty($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database
 
            $midtrans = new CreateSnapTokenService($order);
            $snapToken = $midtrans->getSnapToken();
 
            foreach ($orders as $order){
                $order->snap_token = $snapToken;
                $order->update();
            }
        }
        $order = Order::with(['book', 'user'])->where(['user_id' => auth()->user()->id, 'payment_status' => 1])->first();
        $orders = Order::with(['book', 'user'])->where(['user_id' => auth()->user()->id, 'payment_status' => 1])->get();
 
        return view('cart.show', [
            "title" => "CheckOut",
            "active" => "cart",
            "orders" => $orders,
            "order" => $order,
            'grandTotal' => $request->grandTotal,
            'snapToken' => $snapToken
        ]);
       }
}
