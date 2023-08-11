<footer class="page-footer public-footer" style="margin-top: 0; padding-bottom: 0">
    <div class="footer-content">

        <div class="logo margin-bottom-1">
            <a href="/" class="brand">
                <img src="{{ url('/images/memolife.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            </a>
        </div>

        <nav>
            <a class="{{ request()->routeIs('frontpage') ? 'active' : '' }}"
               href="{{ url('/') }}">
                <i class="fa fa-home" aria-hidden="true"></i>{{ __('Frontpage') }}
            </a>
            <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
               href="{{ url('/admin/dashboard') }}">
                {{ __('Dashboard') }}
            </a>
            <a class="{{ request()->routeIs('sentry') ? 'active' : '' }}"
               href="{{ url('/sentry') }}">
                {{ __('Sentry') }}
            </a>
            @auth
                <a href="{{ url('/admin') }}" class="">{{ __('Admin') }}</a>
            @endauth
        </nav>
    </div>

    <div class="padding-top-bottom-1" style="background: #193F4D;">
        <small class="text-gray-40 fs-12">&copy; 2023 {{ config('app.name') }}
            . {{ __('All rights reserved!') }}</small>
    </div>
</footer>
