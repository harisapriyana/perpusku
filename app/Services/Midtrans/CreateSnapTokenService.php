<?php
 
namespace App\Services\Midtrans;
 
use Midtrans\Snap;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Services\Midtrans\Midtrans;
 
class CreateSnapTokenService extends Midtrans
{
    protected $order;
 
    public function __construct($order)
    {
        parent::__construct();
 
        $this->order = $order;
    }
 
    public function getSnapToken()
    {
        $orders = Order::with(['book', 'user'])->where(['user_id' => auth()->user()->id, 'payment_status' => 1])->get();
        // $data =[[]];
        $total_price = 0;
        $subtotal = 0;
        $taxRate = 0.11;
        $shippingRate = 20000;
        
        foreach($orders as  $order){
            // $dataBaru = [

            //     'id' => $order->id,
            //     'price' => $order->book->price,
            //     'quantity' => $order->quantity,
            //     'name' => $order->book->title
            
            // ];
            // $data [][] = $dataBaru;
            $subtotal += $order->book->price * $order->quantity;
            
        }
        $tax = $subtotal * $taxRate;
        $shipping = ($subtotal > 0 ? $shippingRate : 0);
        $total_price = $subtotal + $tax + $shipping;
        
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->number,
                'gross_amount' => intval($total_price),
            ],
            // 'item_details' => $data,
            'customer_details' => [
                'first_name' => $this->order->user->username,
                'email' => $this->order->user->email,
                'phone' => $this->order->user->phone,
                ]
            ];
            
        // return $params;
        $snapToken = Snap::getSnapToken($params);
 
        return $snapToken;
    }
}