<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Head;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Services\Midtrans\CreateSnapTokenService;
use App\Services\Midtrans\CallbackService;

class CartController extends Controller
{
    public function create(Request $request)
    {
        // $carts = Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();
        // $orders = Order::with(['book', 'user'])->join('heads', 'orders.snap_token', '=','heads.snap_token')->where(['heads.user_id' => auth()->user()->id, 'payment_status' => 1])->get();
        // $cartTotal = $carts->count() + $orders->count();
        // Session::put('cartTotal',$cartTotal);
        // Cart::cartTotal();
        Cart::CardTotal();
        $carts = Cart::GetAllCart();
        // $orders = Order::GetAllOrderUnPaid()->get();
        
        // $head = Head::GetHeadUnPaid()->first();

        $head = Head::where(['user_id' => auth()->user()->id, 'payment_status' => 1])->first();
        
        // echo "<script>alert(".$head.")</script>";
        // dd($head);
        if($head != Null){
            
            $orders = Order::where('head_id', $head->id)->get();
            
            foreach($orders as $order){
                Cart::create([
                    'user_id' => auth()->user()->id,
                    'book_id' => $order->book->id,
                    'quantity' => $order->quantity
                ]);
                $order->delete();
            }
            $head->delete();
        }
        
        return view('cart.cart',[
            "title" => "My Cart",
            "active" => "cart",
            "carts" => $carts,
            
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
 
        // $carts = Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();
        // $orders = Order::with(['book', 'user'])->join('heads', 'orders.snap_token', '=','heads.snap_token')->where(['heads.user_id' => auth()->user()->id, 'payment_status' => 1])->get();
        // $cartTotal = $carts->count() + $orders->count();
        // Session::put('cartTotal',$cartTotal);
        // Cart::cartTotal();
        Cart::CardTotal();
        $carts = Cart::GetAllCart();
        $orders = Order::GetAllOrder();
        
        return view('cart.cart',[
            "title" => "My Cart",
            "active" => "cart",
            "carts" => $carts,
            "orders" => $orders
        ]);
    }

    public function checkout(Request $request)
    {
        $validateData = $request->validate([
            'grandTotal' => 'required'
        ]);
        
        // $carts = Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();
        // $orders = Order::with(['book', 'user'])->join('heads', 'orders.snap_token', '=','heads.snap_token')->where(['heads.user_id' => auth()->user()->id, 'payment_status' => 1])->get();
        // $cartTotal = $carts->count() + $orders->count();
        // Session::put('cartTotal',$cartTotal);
        // Cart::cartTotal();
        Cart::CardTotal();
        $carts = Cart::GetAllCart();
        $orders = Order::GetAllOrder();
        
        return view('cart.checkout', [
                "title" => "CheckOut",
                "active" => "cart",
                "carts" => $carts,
                'grandTotal' => $request->grandTotal,
                "orders" => $orders
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
                // $carts = Cart::where('user_id', auth()->user()->id);
                // $orders = Order::with(['book', 'user'])->join('heads', 'orders.snap_token', '=','heads.snap_token')->where(['heads.user_id' => auth()->user()->id, 'payment_status' => 1])->get();
                // $cartTotal = $carts->count() + $orders->count();
                // Session::put('cartTotal',$cartTotal);
                Cart::CardTotal();
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
        Cart::CardTotal();
    }


    public function order(Request $request)
    {
        $validateData = $request->validate([
            'grandTotal' => 'required'
        ]);
        
        $carts = Cart::GetAllCart();
        
        Head::create([
            // 'snap_token' => $snapToken,
            'user_id' => auth()->user()->id,
            'total_price' =>$request->grandTotal,
            'number' => Str::random(8)
            // 'payment_status' => 1
        ]);


        $head = Head::GetHeadUnPaid();
        foreach ($carts as $cart){
            Order::create([
                'head_id' => $head->id,
                'book_id' => $cart->book_id,
                'quantity' => $cart->quantity
            ]);
            $cart->delete();
        }

        $snapToken = $head->snap_token;
        if (empty($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database
            
            $midtrans = new CreateSnapTokenService($head);
            $snapToken = $midtrans->getSnapToken();
            
            $head->snap_token = $snapToken;
            $head->update();
        }
        
       Cart::CardTotal();

        // $order = Order::with(['book', 'user'])->where(['user_id' => auth()->user()->id, 'payment_status' => 1])->first();
        // $orders = Order::with(['book', 'user'])->where(['user_id' => auth()->user()->id, 'payment_status' => 1])->get();
        $orders = Order::GetAllOrderUnPaid();
        // dd($orders);
 
        return view('cart.show', [
            "title" => "CheckOut",
            "active" => "cart",
            "orders" => $orders,
            'grandTotal' => $request->grandTotal,
            'snapToken' => $snapToken
        ]);
       }

       public function receive()
    {
        $callback = new CallbackService;
        // return "masuk notif";
 
        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $head = $callback->getHead();
 
            if ($callback->isSuccess()) {
                Head::where('id', $head->id)->update([
                    'payment_status' => 2,
                    'payment_type' => $notification->payment_type,
                    'transaction_time' => $notification->transaction_time,
                ]);
            }
 
            if ($callback->isExpire()) {
                Head::where('id', $head->id)->update([
                    'payment_status' => 3,
                    'payment_type' => $notification->payment_type,
                    'transaction_time' => $notification->transaction_time,
                ]);
            }
 
            if ($callback->isCancelled()) {
                Head::where('id', $head->id)->update([
                    'payment_status' => 4,
                    'payment_type' => $notification->payment_type,
                    'transaction_time' => $notification->transaction_time,
                ]);
            }
 
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                    $head
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}
