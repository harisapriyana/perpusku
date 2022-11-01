<?php

namespace App\Models;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['author', 'category'];

    

    //function untuk pencarian dan atau ada request pada url
    public function scopeFilter($query, array $filters){
        //menggunakan function when laravel dan null coalescing php
        $query->when($filters['search'] ?? false, function($query, $search)
        {
            return $query->where('title','like','%' . $search . '%')
                         ->orWhere('body','like','%' . $search . '%');
            
        });

        $query->when($filters['category'] ?? false, function($query, $category)
        {   //menggunakan keyword use agar $category pada function where dikenali oleh return di bawahnya
            return $query->whereHas('category', function($query) use ($category)
            {
                $query->where('slug', $category);
            });

        });
       
        $query->when($filters['author'] ?? false, fn($query, $author)
               => $query->whereHas('author', fn($query)
                => $query->where('alias', $author)
            )

        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
