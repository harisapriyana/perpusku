<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
        <div class="container-fluid ms-5">
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
              @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Welcome back, {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-cart4"></i> My Cart</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form action="/logout" method="get">
                      <button type="submit" class="dropdown-item"><i class="bi bi-door-closed"></i> Logout</button>
                    </form></li>
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