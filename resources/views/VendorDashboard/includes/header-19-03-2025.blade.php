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
            @if (!empty($shopId) && is_numeric($shopId))
                <!-- Cart Icon with Badge - Positioned on the Right -->
                <div class="cart-sec d-flex align-items-center ms-auto me-3">
                    <a class="nav-link d-flex align-items-center"
                        href="{{ route('cart.index', ['shopid' => $shopId, 'vendorid' => $vendorId]) }}"
                        aria-label="Shopping Cart">
                        <i class="fa-solid fa-shopping-cart position-relative">
                            <span
                                class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">
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
            <div class="collapse navbar-collapse justify-content-end position-relative flex-grow-0"
                id="navbarNavDropdown">
                <ul class="navbar-nav gap-lg-4 gap-2">
                    <!-- Vendor Dropdown Menu -->
                    <li class="nav-item dropdown">
                        @if (isset($vendor))
                            <a class="nav-link dropdown-toggle db-header-btn" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $name->vendor_name }}
                            </a>
                        @endif
                        <div class="dropdown">
                            <ul class="dropdown-menu p-0" style="max-height: 300px; overflow: auto; width: 250px;">
                                <!-- Search Input -->
                                <li class="p-2">
                                    <input type="text" id="vendorSearch" class="form-control"
                                        placeholder="Search vendor..." onkeyup="filterVendors()">
                                </li>

                                <!-- Vendor List -->
                                <div id="vendorList">
                                    @foreach ($vendors as $vendor)
                                        <li>
                                            <a class="dropdown-item fs-7 vendor-item"
                                                href="{{ route('vendor-dashboard', $vendor->id) }}">
                                                {{ $vendor->vendor_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </div>

                                <!-- Logout Option -->
                                <li>
                                    <a class="dropdown-item fs-7" href="{{ route('vendor.logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<script>
    function filterVendors() {
        let input = document.getElementById("vendorSearch").value.toLowerCase();
        let items = document.querySelectorAll(".vendor-item");

        items.forEach(item => {
            let text = item.textContent.toLowerCase();
            item.style.display = text.includes(input) ? "" : "none";
        });
    }
</script>
