<header class="p-3 bg-dark text-white shadow rounded-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <form action="{{route('main')}}" method="POST">
          @csrf
          <input type="hidden" name="refresh" value="true">
          <button class="bg-transparent link-secondary border-0 d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-basket-fill text-success" viewBox="0 0 16 16">
                <path d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3z"/>
            </svg>
         </button>
        </form>
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
                      <form method="POST" action="{{route('sendPrices')}}">
                        @csrf
                        <input type="hidden" name="filePath" value="{!! storage_path('files/prices.csv') !!}">
                        <input type="hidden" name="queueName" value="filePath">
                        <button class="btn dropdown-item">Export prices</button>
                      </form>
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
              <button type="button" class="btn btn-outline-light me-3" data-toggle="modal" data-target="#loginWindow">
                Log in
              </button>
              <div class="modal fade" id="loginWindow" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <p class="modal-title text-black ms-2 fs-3" id="loginLabel">Log in options</p>
                      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body text-center pb-4 px-4">
                      <div>
                        <a href="{{ route('login') }}" type="button" class="btn btn-outline-light border border-2 shadow-sm mt-3 col-12">
                          <div class="d-flex align-items-center justify-content-center">
                            <span class="text-black py-1">Log in with</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" class="bi bi-basket-fill text-success" viewBox="0 0 15 21">
                              <path d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3z"/>
                            </svg>
                            <span class="text-black lead">Best</span>
                            <span class="text-success mb-4">items</span>
                          </div>
                        </a>
                      </div>
                      <div>
                        <a href="{{ route('authGoogle') }}" class="btn btn-outline-light border border-2 shadow-sm mt-3 col-12 p-3">
                          <div class="d-flex align-items-center justify-content-center">
                            <span class="text-black me-1 py-1">Log in with</span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 0 24 24" width="32">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/><path d="M1 1h22v22H1z" fill="none"/>
                            </svg>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" type="button" class="btn btn-outline-light">Sign-up</a>
            @endif
            @endauth
          @endif
        </div>
      </div>
    </div>
</header>
