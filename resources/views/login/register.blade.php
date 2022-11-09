@extends('index')

@section('container')
<div class="row justify-content-center">
  <div class="col-lg-6">

    <main class="form-registration w-100 m-auto">
        <form method="post" action="register">
          @csrf
          <h1 class="h3 mb-3 fw-normal text-center">Registration Form</h1>
          
          <div class="form-floating">
            <input type="text" class="form-control rounded-top @error('name') is-invalid @enderror" id="fullname" placeholder="FullName" name="name" value="{{ old('name') }}" required>
            <label for="fullname">FullName</label>
          </div>
          @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
          <div class="form-floating">
              <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="UserName" name="username" value="{{ old('username') }}" required>
              <label for="username">UserName</label>
            </div>
            @error('username')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-floating">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" name="email" value="{{ old('email') }}" required>
                <label for="email">Email address</label>
            </div>
            @error('email')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-floating">
                <input type="password" class="form-control rounded-bottom @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password" name="password" required>
                <label for="floatingPassword">Password</label>
            </div>
            @error('password')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Register</button>
        </form>
        <small class="d-block text-center mt-3">Already registered? <a href="/login"> Login now!</a></small>
      </main>
  </div>
</div>
    
@endsection