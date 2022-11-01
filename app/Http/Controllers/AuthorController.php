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
            "books" => $author->book->load('category', 'author')
        ]);
    }
}
