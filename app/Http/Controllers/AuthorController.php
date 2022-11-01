<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index(){

        return view ('author.authors', [
            'title' => 'Author',
            "active" => "author",
            'authors' => Author::all()
        ]);
        
    }
   
    
    public function show(Author $author){
    
         
        $title = 'by ' . $author->name;

        return view('author.author',[
            "title" => "All Books " . $title,
            "active" => "author",
            'req' => $author->alias,
            // "books" => $author->book->load('category', 'author')
            "books" =>Book::where('author_id', $author->id)->with('author', 'author')->paginate(9)->withQueryString()
        ]);
    }

    public function cari(){
        $author = Author::firstWhere('alias', request('author'));
        $title = 'by ' . $author->name;

        return view('author.author',[
            'title' => 'All Books ' .$title,
            "active" => "book",
            'req' => $author->alias,
            'books' => Book::latest()->filter(request(['search','author']))->paginate(9)->withQueryString()
        ]);
    }
}
