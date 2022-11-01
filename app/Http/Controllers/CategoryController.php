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
            'req' => $category->slug,
            // "books" => $category->book->load('category', 'author')
            "books" =>Book::where('category_id', $category->id)->with('category', 'author')->paginate(9)->withQueryString()
        ]);
    }

    public function cari(){
        $category = Category::firstWhere('slug', request('category'));
        $title = 'in ' . $category->name;

        return view('category.category',[
            'title' => 'All Books ' .$title,
            "active" => "book",
            'req' => $category->slug,
            'books' => Book::latest()->filter(request(['search','category']))->paginate(9)->withQueryString()
        ]);
    }
}
