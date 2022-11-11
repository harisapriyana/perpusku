<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
