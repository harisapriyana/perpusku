<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
        <div class="container-fluid mx-3">
          <a class="navbar-brand" href="/">Perpusku</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link {{ (Request::is("index") || $active === "home") ? 'active' : ''}}" aria-current="page" href="/">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::is("book*") ? 'active' : ''}}" href="/book">Book</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::is("category*") ? 'active' : ''}}" href="/category">Category</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::is("author*") ? 'active' : ''}}" href="/author">Author</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::is("about") ? 'active' : ''}}" href="/about">About Us</a>
              </li>
            </ul>
            <ul class="navbar-nav ms-auto">
              <li><a class="nav-link text-danger fs-3  position-relative" href="/cart/create"><i class="bi bi-cart4"></i>
                @if(Session::get('cartTotal') > 0 ) 
                  <span class="position-absolute bottom-0 start-55 fs-5 translate-middle bg-danger badge rounded-circle p-2" style="--bs-bg-opacity: .5;">
                  {{ Session::get('cartTotal') }} 
                @endif
                <span class="visually-hidden">cart quantity</span></span></a></li>
                <li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
              @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Hi, {{ auth()->user()->username }}
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/costumer"><i class="bi bi-card-list"></i> Profile</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/costumer/order"><i class="bi bi-card-list"></i> My Order</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form action="/logout" method="post">
                      @csrf
                      <button type="submit" class="dropdown-item"><i class="bi bi-door-closed"></i> Logout</button>
                    </form>
                  </li>
                </ul>
              </li>
              @else
              <li class="nav-item">
                <a href="/login" class="nav-link {{ (Request::is("login")  || $active === "login") ? 'active' : ''}}"><i class="bi bi-door-open"></i>Login</a>
              </li>
              @endauth
            </ul>
          </div>
        </div>
      </nav>