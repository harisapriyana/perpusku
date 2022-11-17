<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Head extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function order(){
        return $this->hasMany(Order::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeGetHead(){
        return Head::where('user_id', auth()->user()->id)->first();
    }

    public function scopeGetHeadUnPaid(){
        $head = Head::where(['user_id' => auth()->user()->id, 'payment_status' => 1])->first();
        if($head != Null){

            return $head;
        }
        // ddd($head);
    }
}
