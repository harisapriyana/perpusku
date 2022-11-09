@extends('index')

@section('container')
<div class="row justify-content-center">
  <div class="col-lg-4">

    <main class="form-signin w-100 m-auto">
      @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(session()->has('errorLogin'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('errorLogin') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
        <form action="/login" method="post">
          @csrf
          <h1 class="h3 mb-3 fw-normal text-center">Please Login</h1>
      
          <div class="form-floating">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" name="email" value="{{ old('email') }}" autofocus required>
            <label for="email">Email address</label>
          </div>
          @error('email')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          <div class="form-floating">
            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
            <label for="password">Password</label>
          </div>
          <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Log in</button>
        </form>
        <small class="d-block text-center mt-3">Not registered? <a href="/register"> Register now!</a></small>
      </main>
  </div>
</div>
    
@endsection