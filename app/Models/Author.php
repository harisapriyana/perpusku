<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //function untuk pencarian dan atau ada request pada url
    public function scopeFilter($query, array $filters){
        //menggunakan function when laravel dan null coalescing php
        $query->when($filters['search'] ?? false, function($query, $search)
        {
            return $query->where('title','like','%' . $search . '%')
                         ->orWhere('body','like','%' . $search . '%');
            
        });

               
        $query->when($filters['author'] ?? false, fn($query, $author)
               => $query->whereHas('author', fn($query)
                => $query->where('alias', $author)
            )

        );
    }

    public function book()
    {
        return $this->hasMany(Book::class);
    }

    public function getRouteKeyName()
    {
        return 'alias';
    }
}
