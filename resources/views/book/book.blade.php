@extends('index')

@section('container')
    <h1 class="mb-3 text-center">{{ $title }}</h1>
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <h1 class="mb-3">{{ $book->title }}</h1>
                <p>By : <a href="/book?author={{ $book->author->alias }}" class="text-decoration-none"> {{ $book->author->name }}</a> in <a href="/book?category={{ $book->category->slug }}" class="text-decoration-none"> {{ $book->category->name }}</a></p>
                <img src="https://source.unsplash.com/1200x400?{{ $book->category->name }}" alt="{{ $book->category->name }}" class="img-fluid">
                <p class="mt-2 text-center fs-4">Price : Rp. {{ number_format($book->price, 2) }}</p>
                
                <article class="my-3 fs-5">
                    {!! $book->body !!}    
                </article>
                
                <a href="{{ url()->previous() }}" class="d-block mt-3 text-decoration-none">&#171; Back</a>
            </div>
        </div>
    </div>







@endsection