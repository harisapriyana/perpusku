<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = '';
        $books = Book::latest()->get();

        if(request('category'))
        {
            $category = Category::firstWhere('slug', request('category'));
            $title = 'in ' . $category->name;
            $books = Book::where('category_id', $category->id)->get();
        }

        if(request('author'))
        {
            $author = Author::firstWhere('alias', request('author'));
            $title = 'by ' . $author->name;
            $books = Book::where('author_id', $author->id)->get();
        }

        if(request('search'))
        {
            $books = Book::where('title', 'like','%' . request('search') . '%')
                        ->orWhere('body', 'like','%' . request('search') . '%')->get();
        }

        return view('book.books',[
            'title' => 'All Books ' .$title,
            "active" => "book",
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('book.book',[
            "title" => "Detail of the Book",
            "active" => "book",
            "book" => $book
        ]);
        // return "masuk ke show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
