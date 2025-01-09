<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('homePage') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Connect Friend" style="height: 40px; width: 100px">
        </a>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('homePage') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('homePage') }}">@lang('lang.home')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('friendPage') ? 'active' : '' }}"
                        href="{{ route('friendPage') }}">@lang('lang.friend')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('avatarShopPage') ? 'active' : '' }}"
                        href="{{ route('avatarShopPage') }}">Avatar</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('chat*') ? 'active' : '' }}"
                            href="{{ route('chatPage') }}">Chat</a>
                    </li>
                @endauth
            </ul>
        </div>
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('friendPage') }}" class="d-flex me-2" role="search">
                <input class="form-control me-2" type="text" name="name" placeholder="@lang('lang.search_friend')"
                    aria-label="Search">
                <button class="btn btn-outline-dark" type="submit">@lang('lang.search')</button>
            </form>
            <div class="d-flex align-items-center me-2">
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="languageDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ app()->getLocale() == 'en' ? '🇺🇸 English' : '🇮🇩 Bahasa' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        @if (app()->getLocale() != 'en')
                            <li>
                                <a class="dropdown-item" href="{{ route('set-locale', 'en') }}">🇺🇸 English</a>
                            </li>
                        @endif
                        @if (app()->getLocale() != 'id')
                            <li>
                                <a class="dropdown-item" href="{{ route('set-locale', 'id') }}">🇮🇩 Bahasa</a>
                            </li>
                        @endif
                    </ul>
                </div>
                @auth
                    <div class="mx-2">
                        <span class="text-muted">Coins: <strong>{{ Auth::user()->coin }}</strong></span>
                    </div>
                    <div class="me-2">
                        <a href="{{ route('notificationPage') }}" class="btn btn-dark">
                            Notification
                        </a>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle"
                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_picture ?: asset('assets/img/avatar/avatar-default.jpg') }}"
                                alt="Profile" class="rounded-circle" style="height: 40px; width: 40px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="profileDropdown"
                            style="width: 200px;">
                            <li>
                                <strong class="px-3 d-block text-truncate"
                                    style="max-width: 180px;">{{ Auth::user()->name }}</strong>
                            </li>
                            <li><a class="dropdown-item mt-2" href="{{ route('myProfilePage') }}">@lang('lang.profile')</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('friendRequestPage') }}">@lang('lang.friend_request')</a></li>
                            <li><a class="dropdown-item" href="{{ route('topupPage') }}">@lang('lang.top_up') Coin</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">@lang('lang.logout')</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
            @guest
                <div class="d-flex">
                    <a href="{{ route('loginPage') }}" class="btn btn-dark">@lang('lang.login')</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
