@auth

    <div
        x-data="dropdownData"
        role="button"
        aria-label="Legördülő menu"
        class="dropdown-click user-dropdown-menu {{ $className }}"
        @click.outside="hideDropdown"
    >
        <a @click="toggleDropdown">
            <i class="fa fa-user fs-14" aria-hidden="true"></i>
            <span>{{ Auth::user()->name }}</span>
            <i class="fa fa-caret-down"></i>
        </a>

        <div x-show="openDropdown" class="dropdown-content card padding-0-5">

            <a class="fs-14 dropdown-item margin-bottom-1 {{ request()->routeIs('admin') ? 'active' : '' }}"
               href="{{ route('admin') }}"
            >
                <i class="fa fa-tachometer" aria-hidden="true"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>

        </div>
    </div>

@else
    <div class="user-dropdown-menu {{ $className }}">

    </div>
@endauth
