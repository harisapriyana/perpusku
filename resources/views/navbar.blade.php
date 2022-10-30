<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
        <div class="container-fluid ms-5">
          <a class="navbar-brand" href="/">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link {{ ($active === "home") ? 'active' : ''}}" aria-current="page" href="/index">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ ($active === "book") ? 'active' : ''}}" href="/book">Book</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ ($active === "category") ? 'active' : ''}}" href="/category">Category</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ ($active === "author") ? 'active' : ''}}" href="/author">Author</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ ($active === "about") ? 'active' : ''}}" href="/about">About Us</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>