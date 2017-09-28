<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="x-token" content="{{ env('GRAPHQL_TOKEN') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="css/bulma.io.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="layout-documentation page-elements">
<div class="container">

    <nav class="navbar" role="navigation" aria-label="main navigation">

        <div class="navbar-brand">
            <a class="navbar-item" href="http://bulma.io">
                <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox"
                     width="112" height="28">
            </a>

            <button class="button navbar-burger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        <div class="navbar-menu">


            @guest
                <a class="nav-item" href="{{ route('login') }}">
                    Login
                </a>
                <a class="nav-item" href="{{ route('register') }}">
                    Register
                </a>
                @else
                    <div class="navbar-item">
                        <div class="navbar-dropdown">
                            <div class="dropdown is-active">
                                <div class="dropdown-trigger">
                                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                        <span>Dropdown button</span>
                                        <span class="icon is-small"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <a href="#" class="dropdown-item">
                                            Dropdown item
                                        </a>
                                        <a class="dropdown-item">
                                            Other dropdown item
                                        </a>
                                        <a href="#" class="dropdown-item is-active">
                                            Active dropdown item
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            Other dropdown item
                                        </a>
                                        <hr class="dropdown-divider">
                                        <a href="#" class="dropdown-item">
                                            With a divider
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endguest

        </div>

    </nav>
</div>
<section class="hero is-primary">
    <!-- Hero header: will stick at the top -->
    <div class="hero-head">
        <div class="container">

        </div>
    </div>

    <!-- Hero content: will be in the middle -->
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">
                Title
            </h1>
            <h2 class="subtitle">
                Subtitle
            </h2>
        </div>
    </div>

    <!-- Hero footer: will stick at the bottom -->
    <div class="hero-foot">
        <nav class="tabs">
            <div class="container">
                <ul>
                    <li class="is-active"><a>Overview</a></li>
                    <li><a>Modifiers</a></li>
                    <li><a>Grid</a></li>
                    <li><a>Elements</a></li>
                    <li><a>Components</a></li>
                    <li><a>Layout</a></li>
                </ul>
            </div>
        </nav>
    </div>
</section>

<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>