<script>
    async function getUserCountry() {
        try {
            console.log("Fetching country...");
            let response = await fetch('https://ipapi.co/json/');
            let data = await response.json();
            console.log("Country detected:", data.country_name, "(", data.country_code, ")");

            return data.country_code === "IN"; // Check if country is India
        } catch (error) {
            console.error("Failed to fetch location data:", error);
            return false; // Default to false if the API fails
        }
    }

    function handlePermission(status) {
        if (status === "granted") {
            console.log("Location access granted.");
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;
                    console.log("Latitude:", latitude, "Longitude:", longitude);

                    sendLocationToServer(latitude, longitude);
                    document.body.style.display = "block"; // Show the website
                },
                function(error) {
                    console.error("Error getting location:", error);
                    document.body.remove(); // Remove everything if an error occurs
                }
            );
        } else {
            console.log("Location permission denied.");
            document.body.remove(); // If denied, remove everything
        }
    }

    function checkLocationPermission() {
        if (!("geolocation" in navigator)) {
            console.log("Geolocation is not supported.");
            document.body.remove();
            return;
        }

        console.log("Checking location permissions...");
        navigator.permissions.query({
            name: "geolocation"
        }).then(function(result) {
            console.log("Permission state:", result.state);
            if (result.state === "granted") {
                handlePermission("granted");
            } else if (result.state === "prompt") {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        handlePermission("granted");
                    },
                    function(error) {
                        console.error("User denied location access:", error);
                        document.body.remove();
                    }
                );
            } else {
                document.body.remove();
            }
        });
    }

    async function sendLocationToServer(lat, long) {
        console.log("Sending location to server...");
        let response = await fetch(route("get-user-location", {
            lat,
            long
        }));
        let data = await response.json();
        fetch('/save-user-location', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    latitude: lat,
                    longitude: long,
                    data: data
                })
            })
            .then(response => response.json())
            .then(data => console.log("Server response:", data))
            .catch(error => console.error("Location not sent:", error));
    }

    // First, check if the user is from India
    // getUserCountry().then(isFromIndia => {
    //     document.body.style.display = "none";
    //     if (isFromIndia) {
    //         console.log("User is from India, checking location...");
    //         checkLocationPermission(); // Request location only if from India
    //     } else {
    //         // console.log("User is not from India. Hiding website.");
    //         // document.body.remove(); // Hide everything if not from India
    //     }
    // });
</script>
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
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Shop
                        </a>
                        <ul class="dropdown-menu p-0">
                            <li><a class="dropdown-item" href="/shop">Wine</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Niagara Region
                        </a>
                        <ul class="dropdown-menu p-0">
                            <li><a class="dropdown-item" href="{{ route('accommodations') }}">Accommodations</a></li>
                            <li><a class="dropdown-item" href="{{ route('excursion-listing') }}">Excursions</a></li>
                            <li><a class="dropdown-item" href="{{ route('wineries-listing') }}">Wineries</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('events') }}">Events</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Support Local
                        </a>
                        <ul class="dropdown-menu p-0">
                            <li><a class="dropdown-item" href="{{ route('licensed') }}">Licensees</a></li>
                            <li><a class="dropdown-item" href="{{ route('non-licensed') }}">Non-Licensed</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            @if (!authCheck()['is_logged_in']) href="{{ route('register') }}" @else href="{{ route('guest-rewards') }}" @endif>Guests
                            Rewards</a>
                    </li>

                    @if (!authCheck()['is_logged_in'])
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="nav-link login-btn dropdown-toggle" href="{{ route('login') }}"
                                    id="loginOption" data-bs-toggle="dropdown" aria-expanded="false">Login</a>
                                <ul class="dropdown-menu" aria-labelledby="loginOption">
                                    <li><a class="dropdown-item rounded-top" href="{{ route('customer.login') }}">User Account</a></li>
                                    <li><a class="dropdown-item rounded-bottom"
                                            href="{{ route('vendor.login') }}">Vendor Account</a></li>
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
                                    <a class="dropdown-item"
                                        href="/vendor/dashboard/{{ Auth::guard('vendor')->user()->id }}">Dashboard</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @elseif (authCheck()['is_logged_in'] && authCheck()['user_type'] === 'admin')
                            <li class="nav-item">
                                <a class="nav-link login-btn" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- ========== Tab Sec Start ========== -->
    <section class="tab-content-sec px-sm-4 px-2 border-bottom">
        <div class="container-fluid">
            <div class="inner-content">
                <ul class="list-unstyled d-flex align-items-center mb-0 gap-4">
                    <li>
                        <a href="{{ route('accommodations') }}" class="text-decoration-none">
                            Directories
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('accommodations') }}"
                            class="text-decoration-none {{ request()->routeIs('accommodations') ? 'border-bottom border-dark' : '' }}">
                            Accommodations
                        </a>
                        @if (request()->routeIs('accommodations'))
                            <span id="records-found" class="text-center">[ {{ $vendorCount }} ]</span>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('excursion-listing') }}"
                            class="text-decoration-none {{ request()->routeIs('excursion-listing') ? 'border-bottom border-dark' : '' }}">
                            Excursions
                        </a>
                        @if (request()->routeIs('excursion-listing'))
                            <span id="records-found" class="text-center">[ {{ $vendorCount }} ]</span>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('wineries-listing') }}"
                            class="text-decoration-none {{ request()->routeIs('wineries-listing') ? 'border-bottom border-dark' : '' }}">
                            Wineries
                        </a>
                        @if (request()->routeIs('wineries-listing'))
                            <span id="records-found" class="text-center">[ {{ $vendorCount }} ]</span>
                        @endif
                    </li>
                    <li>
                        <a href="/events"
                            class="text-decoration-none {{ request()->is('events') ? 'border-bottom border-dark' : '' }}">
                            Events
                        </a>
                        @if (request()->routeIs('events'))
                            <span id="records-found" class="text-center">[ {{ $vendorCount }} ]</span>
                        @endif
                    </li>
                    <li>
                        <a href="/licensed"
                            class="text-decoration-none {{ request()->is('licensed') ? 'border-bottom border-dark' : '' }}">
                            Licensees
                        </a>
                        @if (request()->is('licensed'))
                            <span id="records-found" class="text-center">[ {{ $vendorCount }} ]</span>
                        @endif
                    </li>
                    <li>
                        <a href="/non-licensed"
                            class="text-decoration-none {{ request()->is('non-licensed') ? 'border-bottom border-dark' : '' }}">
                            Non-Licensed
                        </a>
                        @if (request()->is('non-licensed'))
                            <span id="records-found" class="text-center">[ {{ $vendorCount }} ]</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- ========== Tab Sec End ========== -->
</header>
