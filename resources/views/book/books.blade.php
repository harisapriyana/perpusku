@extends('index')

@section('container')
    <h1 class="mb-3 text-center">{{ $title }}</h1>

    <div class="row justify-content-center mb-3">
      <div class="col-md-6">
        <form action="/book">
            {{-- menyisipkan request category atau author jika sebelum pencarian sudah masuk ke category atau author --}}
            @if (request('category')) 
              <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('author'))
              <input type="hidden" name="author" value="{{ request('author') }}">
            @endif
          <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Search...." name="search" value="{{ request('search') }}">
              <button class="btn btn-primary" type="submit" >Search</button>
          </div>
        </form>
      </div>
    </div>
    
    @if ($books->count())
    <div class="container">
        <div class="row">
            @foreach ($books as $book)    
            <div class="col-md-4 mb-3">
                <div class="card mb-3">
                <div class="position-absolute bg-dark px-3 py-2" style="background-color: rgba(0, 0, 0, 0.5)"><a href="/book?category={{ $book->category->slug }}" class="text-decoration-none text-light"> {{ $book->category->name }}</a></div>
                <img src="https://source.unsplash.com/1200x400?{{ $book->category->name }}" class="card-img-top" alt="{{ $book->category->name }}">
                <div class="card-body text-center">
                    <h3 class="card-title"><a href="/book/{{ $book->slug }}" class="text-decoration-none text-dark" >{{ $book->title }}</a></h3>
                        <p>
                        <small class="text-muted">
                            By : <a href="/book?author={{ $book->author->alias }}" class="text-decoration-none">{{ $book->author->name }} </a>
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

    {{-- untuk pagination --}}
    <div class="d-flex justify-content-end">
        {{ $books->links() }}
    </div>
    
@endsection