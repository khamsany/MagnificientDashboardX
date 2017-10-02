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
<body>
<div id="root">
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
            <div class="navbar-start">

            </div>
            <div class="navbar-end">
            @guest
                <a class="nav-item" href="{{ route('login') }}">
                    Login
                </a>
                <a class="nav-item" href="{{ route('register') }}">
                    Register
                </a>
                    @else
                        <div class="navbar-item has-dropdown is-hoverable">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <div class="navbar-link">
                                {{ Auth::user()->name }}
                            </div>
                            <div id="moreDropdown" class="navbar-dropdown is-right">
                                <a class="navbar-item" href="javascript:void(0)" @click="changeProject(project.id)"
                                   v-for="project in viewer.projects">
                                    <div class="level is-mobile">
                                        <div class="level-left">
                                            <div class="level-item">
                                                <p>
                                                    <strong>@{{ project.name }}</strong>
                                                    <br>
                                                    <small>@{{ project.client_name }} (@{{project.role}})</small>
                                                </p>
                                            </div>
                                        </div>
                                        {{--<div class="level-right">--}}
                                        {{--<div class="level-item">--}}
                                        {{--<span class="icon has-text-info"><i class="fa fa-plug"></i></span>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                    </div>
                                </a>
                                <div class="navbar-divider"></div>
                                <a class="navbar-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                                    <div class="level is-mobile">
                                        <div class="level-left">
                                            <div class="level-item">
                                                <p>
                                                    <strong>Sign out</strong>
                                                </p>
                                    </div>
                                </div>
                                        <div class="level-right">
                                            <div class="level-item">
                                                <span class="icon has-text-info"><i class="fa fa-plug"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endguest
            </div>
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
        <div class="container">
            <h1 class="title" v-if="project">
                @{{ project.name }}
            </h1>
            <h2 class="subtitle" v-if="project">
                @{{ project.description }}
            </h2>
        </div>
    </div>

</section>
<section class="section">
    @yield('content')
</section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.slim.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>