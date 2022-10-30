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
            'title' => 'category',
            'categories' => Category::all()
        ]);
    }
   
    
    public function show(Category $category){
        $category = Category::findOrFail('slug', $category);
        $title = 'in ' . $category->name;

        return view('category.category',[
            "title" => "All Books " . $title,
            "books" => Book::latest()->filter(request('category'))
        ]);
    }
}
