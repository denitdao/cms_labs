<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CMS')</title>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>
    <script src="{{ asset('js/general.js')}}" type="text/javascript"></script>
    @yield('scripts')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue_grey-amber.min.css" />
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    @yield('stylesheets')
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header mdl-layout__header--scroll mdl-shadow--2dp">
        <div class="mdl-layout__header-row">
            <!-- Title -->
            <a class="mdl-navigation__link" href="/home"><span class="mdl-layout-title">Lab02</span></a>
            <!-- Add spacer, to align navigation to the right -->
            <div class="mdl-layout-spacer"></div>
            <!-- Search -->
            <form action="#">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable my-search">
                    <label class="mdl-button mdl-js-button mdl-button--icon" for="search">
                        <i class="material-icons">search</i>
                    </label>
                    <div class="mdl-textfield__expandable-holder">
                        <input class="mdl-textfield__input" type="text" id="search">
                        <label class="mdl-textfield__label" for="sample-expandable">Expandable Input</label>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <nav class="mdl-navigation mdl-layout--large-screen-only">
                <button id="demo-menu-lower-right"
                        class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">more_vert</i>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                    for="demo-menu-lower-right">
                    @if($lang == 'en')
                        <li class="mdl-menu__item"><a class="mdl-menu__item" href="{{ $path }}">Українська</a></li>
                    @else
                        <li class="mdl-menu__item"><a class="mdl-menu__item" href="{{ $path }}/en">English</a></li>
                    @endif
                    <li class="mdl-menu__item"><a class="mdl-menu__item" href="/page">{{ $lang == 'ua' ? 'Адміністрування' : 'Admin' }}</a></li>
                    <li class="mdl-menu__item"><a class="mdl-menu__item" href="#{{-- route('login') --}}">{{ $lang == 'ua' ? 'Увійти' : 'Login' }}</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- Drawer -->
    <div class="mdl-layout__drawer mdl-layout--small-screen-only">
        <span class="mdl-layout-title">{{ $lang == 'ua' ? 'Меню' : 'Menu' }}</span>
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link" href="/page">{{ $lang == 'ua' ? 'Адміністрування' : 'Admin' }}</a>
            @if($lang == 'en')
                <a class="mdl-navigation__link" href="{{ $path }}">Українська</a>
            @else
                <a class="mdl-navigation__link" href="{{ $path }}/en">English</a>
            @endif
            <a class="mdl-list__item mdl-navigation__link my-nav-link" href="#{{-- route('login') --}}">
                <span class="mdl-list__item-primary-content">
                    <i class="material-icons mdl-list__item-icon">person</i>
                    {{ $lang == 'ua' ? 'Увійти' : 'Login' }}
                </span>
            </a>
        </nav>
    </div>
    <main class="mdl-layout__content">
        <div class="my-space">
        <!-- Content grid -->
            <div class="mdl-grid">
                @section('content') {{--MUST BE CHANGED--}}
                ERROR
                @show
            </div>
        </div>
        <!-- Footer -->
        <footer class="mdl-mini-footer">
            <div class="mdl-mini-footer__left-section">
                <div class="mdl-logo">© Denys Churchyn</div>
            </div>
            <div class="mdl-mini-footer__right-section">
                <ul class="mdl-mini-footer__link-list">
                    <li><a href="/home">{{ $lang == 'ua' ? 'Головна' : 'Home' }}</a></li>
                    <li><a href="#{{-- route('login') --}}">{{ $lang == 'ua' ? 'Увійти' : 'Login' }}</a></li>
                </ul>
            </div>
        </footer>
    </main>
</div>
</body>
</html>
