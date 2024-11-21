@php
    $user = Auth::user();
    $vendors = $user->vendors;
    $vendor = $vendors->first();
    $currentUrl = Request::url();
    $urlParts = explode('/', $currentUrl);
    $vendorId = end($urlParts);
    $shopId = $urlParts[count($urlParts) - 2];
    $name = $user->vendors->find($vendorId);
    $cartItemCount = wineryCart($shopId, $vendorId);
@endphp
<header>
    <nav class="navbar navbar-expand-lg px-sm-4 px-2 py-0">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Logo">
            </a>
            @if(!empty($shopId) && is_numeric($shopId))
            <!-- Cart Icon with Badge - Positioned on the Right -->
            <div class="d-flex align-items-center ms-auto me-3">
                <a class="nav-link d-flex align-items-center" href="{{ route('cart.index', ['shopid' => $shopId,'vendorid' => $vendorId]) }}" aria-label="Shopping Cart">
                    <i class="fa-solid fa-shopping-cart position-relative">
                        <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">
                            {{ $cartItemCount ?? 0 }}
                        </span>
                    </i>
                    <span class="ms-2">Cart (<span id="cartItemCount">{{ $cartItemCount ?? 0 }}</span>)</span>
                </a>
            </div>
            @endif
            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible Navbar Items -->
            <div class="collapse navbar-collapse justify-content-end position-relative" id="navbarNavDropdown">
                <ul class="navbar-nav gap-lg-4 gap-2">
                    <!-- Vendor Dropdown Menu -->
                    <li class="nav-item dropdown">
                        @if (isset($vendor))
                            <a class="nav-link dropdown-toggle db-header-btn" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $name->vendor_name }}
                            </a>
                        @endif
                        <ul class="dropdown-menu p-0" style="max-height: 300px; overflow: auto;">
                            @foreach ($vendors as $vendor)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ url('/vendor-dashboard', ['vendorId' => $vendor->id]) }}">
                                        {{ $vendor->vendor_name }}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
