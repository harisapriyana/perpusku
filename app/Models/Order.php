<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function head(){
        return $this->belongsTo(Head::class);
    }

    public function scopeGetAllOrder(){
        $head = Head::GetHead()->first();
        if($head != Null){
            return $order = Order::with(['book'])->where('head_id', $head->id)->get();
        }
    }

    public function scopeGetAllOrderUnPaid(){
        // $head = Head::where(['user_id' => auth()->user()->id, 'payment_status' => 1])->first();
        $head = Head::GetHeadUnPaid();
        if($head != Null){

            return $order = Order::with(['book'])->where('head_id', $head->id)->get();
        }
    }
}
