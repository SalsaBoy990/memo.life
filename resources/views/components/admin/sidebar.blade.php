<aside>
    <header>
        <h3 class="text-white fs-18">{{ __('Table of Content') }}</h3>
    </header>
    <div class="sidebar-content">

        <!-- Custom content goes here -->
        <?php if (isset($sidebar)) { ?>

        {{ $sidebar }}

        <?php } ?><!-- Custom content goes here END -->

        <div class="padding-1">
            <ul class="navbar-nav margin-top-0 padding-left-0 no-bullets fs-14">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <!-- Custom links -->

                    @role('super-administrator|administrator')

                    <!-- Manage posts/articles link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('post.manage') ? 'active' : '' }}"
                           href="{{ route('post.manage') }}"
                        >
                            <i class="fa-regular fa-newspaper"></i>
                            <span>{{ __('Manage posts') }}</span>
                        </a>
                    </li>


                    <!-- Manage categories link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('category.manage') ? 'active' : '' }}"
                           href="{{ route('category.manage') }}"
                        >
                            <i class="fa-solid fa-folder-open"></i>
                            <span>{{ __('Manage categories') }}</span>
                        </a>
                    </li>


                    <!-- Manage tags link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tag.manage') ? 'active' : '' }}"
                           href="{{ route('tag.manage') }}"
                        >
                            <i class="fa-solid fa-tags"></i>
                            <span>{{ __('Manage tags') }}</span>
                        </a>
                    </li>


                    <!-- Manage media link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('media.manage') ? 'active' : '' }}"
                           href="{{ route('media.manage') }}"
                        >
                            <i class="fa-solid fa-file-image"></i>
                            <span>{{ __('Manage media') }}</span>
                        </a>
                    </li>

                    <!-- Manage events-->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('event.manage') ? 'active' : '' }}"
                           href="{{ route('event.manage') }}"
                        >
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>{{ __('Manage events') }}</span>
                        </a>
                    </li>

                    <!-- Manage organizers -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organizer.manage') ? 'active' : '' }}"
                           href="{{ route('organizer.manage') }}"
                        >
                            <i class="fa-solid fa-users"></i>
                            <span>{{ __('Manage organizers') }}</span>
                        </a>
                    </li>

                    <!-- Manage locations-->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('location.manage') ? 'active' : '' }}"
                           href="{{ route('location.manage') }}"
                        >
                            <i class="fa-solid fa-location-dot"></i>
                            <span>{{ __('Manage locations') }}</span>
                        </a>
                    </li>

                    @endrole

                    @role('super-administrator')
                    <!-- Manage users link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.manage') ? 'active' : '' }}"
                           href="{{ route('user.manage') }}"
                        >
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <span>{{ __('Manage users') }}</span>
                        </a>
                    </li>

                    <!-- Role/Permissions link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('role-permission.manage') ? 'active' : '' }}"
                           href="{{ route('role-permission.manage') }}"
                        >
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            <span>{{ __('Roles and Permissions') }}</span>
                        </a>
                    </li>
                    @endrole

                    <!-- Account link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.account') ? 'active' : '' }}"
                           href="{{ route('user.account', auth()->id()) }}"
                        >
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>{{ __('My Account') }}</span>
                        </a>
                    </li>

                    <!-- Custom links END -->
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"
                        >
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            {{ __('Logout') }}
                        </a>

                        <form
                            id="logout-form"
                            action="{{ route('logout') }}"
                            method="POST"
                            class="hide"
                        >
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</aside>
