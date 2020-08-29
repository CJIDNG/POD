<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">

    <meta property="fb:app_id" content="123456789">
    <meta property="og:url" content="">
    <meta property="og:type" content="">
    <meta property="og:title" content="">
    <meta property="og:image" content="">
    <meta property="og:image:alt" content="">
    <meta property="og:description" content="">
    <meta property="og:site_name" content="">
    <meta property="og:locale" content="en_US">
    <meta property="article:author" content="">

    <meta name="twitter:card" content="">
    <meta name="twitter:site" content="">
    <meta name="twitter:creator" content="">
    <meta name="twitter:url" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">
    <meta name="twitter:image:alt" content="">

    <link rel="author" href="">
    <link rel="publisher" href="">
    <meta itemprop="name" content="">
    <meta itemprop="description" content="">
    <meta itemprop="image" content="">

    <meta name="google" content="notranslate">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script async defer src="https://buttons.github.io/buttons.js"></script>
</head>
<body>
    <div id="app">

        <!-- <nav class="navbar navbar-horizontal navbar-expand-lg navbar-dark bg-primary">
          <div class="container">
            <router-link to="/" class="navbar-brand mr-lg-3">
              <img class="navbar-brand-dark" src="/assets/svg/light.svg" alt="menuimage" />
              <img class="navbar-brand-light" src="/assets/svg/dark.svg" alt="menuimage" />
            </router-link>
            <div class="d-flex align-items-center">
              @guest
                <a class="btn btn-md btn-secondary animate-up-2" href="{{ route('login') }}">
                  <i class="fas fa-user mr-2"></i> 
                  {{ __('Login') }}
                </a>
                @if (Route::has('register'))
                  <a class="btn btn-md btn-primary animate-up-2" href="{{ route('register') }}">
                  <i class="fas fa-user mr-2"></i> 
                    {{ __('Register') }}
                  </a>
                @endif
              @else
                <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                  </a>

                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </div>
                </li>
              @endguest

              <button
                class="navbar-toggler ml-2"
                type="button"
                data-toggle="collapse"
                data-target="#navbar-default-primary"
                aria-controls="navbar-default-primary"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class="navbar-toggler-icon"></span>
              </button>
            </div>
          </div>
        </nav> -->

        <main>
            @yield('content')
        </main>
    </div>
    @javascript('CurrentTenant', $currentTenant ?? '')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
