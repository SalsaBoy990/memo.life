<header class="page-header">
    <div class="header-content">
        <div class="logo">
            <a href="/" class="brand">
                <img src="{{ url('/images/memolife.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            </a>
        </div>
        @if (Route::has('login'))
            <div class="main-navigation">
                <nav id="main-menu">
                    @auth
                        <a class="{{ request()->routeIs('frontpage') ? 'active' : '' }}"
                           href="{{ url('/') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>{{ __('Frontpage') }}
                        </a>

                        <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ url('/admin/dashboard') }}">
                            <i class="fa fa-tachometer" aria-hidden="true"></i>{{ __('Dashboard') }}
                        </a>

                        @role('super-administrator|administrator')

                        @endrole

                        <a class="{{ request()->routeIs('admin') ? 'active' : '' }}"
                           href="{{ url('/admin/app') }}">
                            {{ __('Open app') }}<i class="fa-solid fa-square-arrow-up-right margin-left-0-5"></i>
                        </a>


                        <div
                            x-data="dropdownData"
                            class="dropdown-click"
                            @click.outside="hideDropdown"
                        >
                            <a @click="toggleDropdown">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fa fa-caret-down"></i>
                            </a>

                            <div x-show="openDropdown" class="dropdown-content card padding-0-5">

                                <a class="dropdown-item"
                                   href="{{ route('user.account', auth()->id()) }}"
                                >
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span>{{ __('My Account') }}</span>
                                </a>


                                <a
                                    class="dropdown-item"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    <span>{{ __('Logout') }}</span>

                                </a>

                                <form
                                    id="logout-form"
                                    action="{{ route('logout') }}"
                                    method="POST"
                                    class="d-none"
                                >
                                    @csrf
                                </form>
                            </div>
                        </div>

                    @else

                    @endauth

                </nav>

                <div x-data="offCanvasMenuData">
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
                    <div class="sidenav relative"
                         tabindex="-1"
                         id="main-menu-offcanvas"
                         @click.outside="closeOnOutsideClick()"
                    >
                        <a href="javascript:void(0)"
                           id="main-menu-close-button"
                           @click="closeOffcanvasMenu()"
                           class="close-btn fs-18 absolute topright padding-0-5"
                        >
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>

                        <div id="mobile-menu"></div>

                    </div>

                </div>
            </div>
            <div class="right-menu">

                @auth
                    @php
                        $light = __('Light mode');
                        $dark = __('Dark mode');
                    @endphp
                    <button
                        class="darkmode-toggle margin-top-0"
                        rel="button"
                        @click="toggleDarkMode"
                        x-text="isDarkModeOn() ? '🔆' : '🌒'"
                        :title="isDarkModeOn() ? '{{ $light }}' : '{{ $dark }}'"
                    >
                    </button>

                    <div class="logout">
                        <a class="button logout-button"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>

                        <form
                            id="logout-form"
                            action="{{ route('logout') }}"
                            method="POST"
                            class="d-none"
                        >
                            @csrf
                        </form>
                    </div>

                @endauth
            </div>
        @endif
    </div>
</header>


