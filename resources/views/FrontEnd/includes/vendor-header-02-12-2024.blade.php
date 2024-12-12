<header>
    <nav class="navbar navbar-expand-lg px-sm-4 px-2 py-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end position-relative" id="navbarNavDropdown">
                <ul class="navbar-nav gap-lg-4 gap-2">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Niagara Region1
                        </a>
                        <ul class="dropdown-menu p-0">
                            <li><a class="dropdown-item" href="{{ route('accommodations') }}">Accommodations</a></li>
                            <li><a class="dropdown-item" href="{{ route('excursion-listing') }}">Excursions</a></li>
                            <li><a class="dropdown-item" href="{{ route('wineries-listing') }}">Wineries</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Support Local
                        </a>
                        <ul class="dropdown-menu p-0">
                            <li><a class="dropdown-item" href="{{ route('licensed') }}">Licensed</a></li>
                            <li><a class="dropdown-item" href="{{ route('non-licensed') }}">Non-Licensed</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            @if(!authCheck()['is_logged_in']) href="{{ route('register') }}" @else href="{{ route('guest-rewards') }}" @endif>Guests
                            Rewards</a>
                    </li>

                    @if (!authCheck()['is_logged_in'])
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="nav-link login-btn dropdown-toggle" href="{{ route('login') }}"
                                    id="loginOption" data-bs-toggle="dropdown" aria-expanded="false">Login</a>
                                <ul class="dropdown-menu" aria-labelledby="loginOption">
                                    <li><a class="dropdown-item rounded-top" href="{{ route('customer.login') }}">Login
                                            as
                                            User</a></li>
                                    <li><a class="dropdown-item rounded-bottom" href="{{ route('vendor.login') }}">Login as
                                            Vendor</a></li>
                                </ul>
                            </div>
                        </li>
                    @else
                        @if (authCheck()['is_logged_in'] && authCheck()['user_type'] === 'customer')
                            <li class="nav-item">
                                <a class="nav-link login-btn" href="{{ route('user-dashboard') }}">User Dashboard</a>
                            </li>
                        @elseif (authCheck()['is_logged_in'] && authCheck()['user_type'] === 'vendor')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Vendor Dashboard
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/vendor-dashboard/{vendorid}">Dashboard</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
