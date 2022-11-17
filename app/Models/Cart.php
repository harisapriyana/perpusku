<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeGetAllCart(){
        return Cart::with(['book', 'user'])->where('user_id', auth()->user()->id)->get();
    }

    public function scopeCardTotal(){
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        // $orders = Order::GetAllOrderUnPaid();
        $cartTotal = $carts->count();
        $head = Head::where(['user_id' => auth()->user()->id, 'payment_status' => 1])->first();
        if($head != Null){

            $orders = Order::with(['book', 'user'])->where('head_id', $head->id)->get();
            $cartTotal = $carts->count() + $orders->count();
        }
        Session::put('cartTotal',$cartTotal);
        // return $cartTotal;
    }
}
