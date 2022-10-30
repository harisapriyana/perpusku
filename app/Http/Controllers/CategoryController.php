<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Book;

class CategoryController extends Controller
{
    public function index(){

        return view ('category.categories', [
            'title' => 'Category',
            "active" => "category",
            'categories' => Category::all()
        ]);
        
    }
   
    
    public function show(Category $category){
    
         
        $title = 'in ' . $category->name;

        return view('category.category',[
            "title" => "All Books " . $title,
            "active" => "category",
            "books" => Book::where('category_id', $category->id)->get()
        ]);
    }
}
