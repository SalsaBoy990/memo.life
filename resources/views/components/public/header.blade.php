<header class="page-header">
    <div class="header-content">
        <div class="logo">
            <a href="/" class="brand">
                <img src="{{ url('/images/memolife.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            </a>
        </div>
        @if (Route::has('login'))
            <div class="main-navigation">
                <nav id="main-menu" class="fs-16">

                    <a class="{{ request()->routeIs('frontpage') ? 'active' : '' }}"
                       href="{{ url('/') }}">
                        <i class="fa fa-home" aria-hidden="true"></i>{{ __('Frontpage') }}
                    </a>

                    <a class="{{ request()->routeIs('admin') ? 'active' : '' }}"
                       href="{{ url('/admin/app') }}">
                        {{ __('Open app') }}<i class="fa-solid fa-square-arrow-up-right margin-left-0-5"></i>
                    </a>

                    <a class="{{ request()->routeIs('sentry') ? 'active' : '' }}"
                       href="{{ url('/debug-sentry') }}">
                        {{ __('Sentry') }}
                    </a>
                    <x-global.user-drop-down-menu :className="'user-dropdown-menu-desktop'"/>
                </nav>



                <div x-data="offCanvasMenuData">
                    <div class="flex flex-row">

                        <button id="main-menu-offcanvas-toggle"
                                @click="toggleOffcanvasMenu()"
                                class="primary alt margin-left-0-5"
                                data-collapse-toggle="navbar-default"
                                type="button"
                                aria-controls="navbar-default"
                                aria-expanded="false"
                        >
                            <span class="sr-only">{{__('Open main menu')}}</span>
                            <i :class="sidenav === true ? 'fa fa-times' : 'fa fa-bars'" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="sidenav relative"
                         tabindex="-1"
                         id="main-menu-offcanvas"
                         @click.outside="closeOnOutsideClick()"
                    >
                        <a href="javascript:void(0)"
                           id="main-menu-close-button"
                           @click="closeOffcanvasMenu()"
                           class="close-button fs-18 absolute topright padding-0-5"
                        >
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>

                        <div id="mobile-menu"></div>

                    </div>

                </div>


            </div>
            <div class="right-menu">
                @auth
                    <a class="{{ request()->routeIs('admin') ? 'active' : '' }}"
                       href="{{ url('/admin/app') }}">
                        {{ __('Open app') }}<i class="fa-solid fa-square-arrow-up-right margin-left-0-5"></i>
                    </a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="button register-button margin-top-0">{{ __('Register') }}</a>
                    @endif
                    <a href="{{ route('login') }}"
                       class="button login-button margin-top-0">{{ __('Log in') }}</a>
                @endauth
            </div>
        @endif
    </div>
</header>


