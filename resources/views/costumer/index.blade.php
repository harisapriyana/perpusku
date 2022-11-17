@extends('index')

@section('container')
  
@include('costumer.navbar')

<div class="container-fluid">
  <div class="row">
    @include('costumer.sidebar')

    <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
      @yield('costomer')
    </main>
  </div>
</div>
@endsection
