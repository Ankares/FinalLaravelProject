<header class="p-3 bg-dark text-white shadow rounded-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="{{route('main')}}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-basket-fill text-success" viewBox="0 0 16 16">
                <path d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3z"/>
            </svg>
        </a>
        <p class="mt-4 lead">Best</p>
        <p class="text-success">items</p>
        <ul class="nav offset-0 col-12 col-lg-auto offset-lg-1 me-lg-auto mb-2 justify-content-center mb-md-0">
          @auth
            @role('simple-user')
              <li class="lead">
                <a href="{{route('cart')}}"" class="nav-link px-2 text-white">Cart</a>
              </li>
            @endrole
            @role('administrative-user')
              <li class="lead">
                <a href="{{route('create')}}" class="nav-link px-2 text-white">Add product</a>
              </li>
              <li class="lead">
                <a href="{{route('showExports')}}" class="nav-link px-2 text-white">Exported files</a>
              </li>
            @endrole
          @endauth
        </ul>
        <div class="text-end">
          @if (Route::has('login'))
            @auth
            <div class="d-flex">
              <div class="dropdown">
                <button class="px-3 btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{Auth::user()->name}}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a>
                  @role('administrative-user')
                    <div>
                      <a href="{{route('export')}}" class="btn dropdown-item">Export prices</a>
                    </div>
                  @endrole
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item">Log out</button>
                  </form>
                </div>
              </div>
            </div>
            @else
              <a href="{{ route('login') }}" type="button" class="btn btn-outline-light me-3">Log in</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" type="button" class="btn btn-outline-light">Sign-up</a>
            @endif
            @endauth
          @endif
        </div>
      </div>
    </div>
</header>
