@extends('index')

@section('container')
    <h1 class="mb-3 text-center">{{ $title }}</h1>
    
    @if ($books->count())
    <div class="container">
        <div class="row">
            @foreach ($books as $book)    
            <div class="col-md-4 mb-3">
                <div class="card mb-3">
                <img src="https://source.unsplash.com/1200x400?{{ $book->category->name }}" class="card-img-top" alt="{{ $book->category->name }}">
                <div class="card-body text-center">
                    <h3 class="card-title"><a href="/book/{{ $book->slug }}" class="text-decoration-none text-dark" >{{ $book->title }}</a></h3>
                        <p>
                        <small class="text-muted">
                            By : <a href="/book?author={{ $book->author->alias }}" class="text-decoration-none">{{ $book->author->name }}</a> in <a href="/book?category={{ $book->category->slug }}" class="text-decoration-none"> {{ $book->category->name }}</a>
                            {{ $book->created_at->diffForHumans() }}
                        </small>
                        </p>
                    <p class="card-text">{{ $book->excerpt }}</p>
                    <a href="/book/{{ $book->slug }}" class="text-decoration-none btn btn-primary">Read more</a>
                </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>




    @else
        <p class="text-center fs-4">No book found</p>
    @endif


@endsection