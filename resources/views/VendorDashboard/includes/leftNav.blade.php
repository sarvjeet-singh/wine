@php
    $id = request()->route('vendorid');
    $vendor = getVendor($id);
@endphp
<style>
    .expand-icon.rotate {
        transform: rotate(90deg);
        transition: transform 0.3s ease;
    }
</style>
<div class="col-auto ps-0 pe-1 ms-3 left-navbar">
    <div class="d-flex flex-column align-items-center align-items-sm-start text-white">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <div class="side-head w-100 p-3 mb-1 rounded-top" style="background-color: #348a96; color: white;">
                <h6 class="mb-0 fw-bold">Vendor Dashboard</h6>
            </div>

            <!-- Overview Menu -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#overview" role="button"
                    aria-expanded="{{ request()->routeIs('vendor-dashboard') ? 'true' : 'false' }}"
                    aria-controls="overview">
                    <div><i class="fas fa-folder-open menu-icon"></i> Overview</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('vendor-dashboard') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('vendor-dashboard') ? 'show' : '' }}" id="overview">
                    <ul class="nav flex-column sub-menu mt-2">
                        <li class="nav-item"><a
                                class="nav-link {{ request()->routeIs('vendor-dashboard') ? 'active' : '' }}"
                                href="{{ route('vendor-dashboard', ['vendorid' => $id]) }}">
                                <i class="fas fa-file-alt menu-icon"></i> Dashboard</a></li>
                    </ul>
                </div>
            </li>

            <!-- Content Management Menu -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu2" role="button"
                    aria-expanded="{{ request()->routeIs('vendor-media-gallary') ? 'true' : 'false' }}"
                    aria-controls="menu2">
                    <div><i class="fas fa-cogs menu-icon"></i> Content Management</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('vendor-media-gallary') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('vendor-media-gallary') ? 'show' : '' }}" id="menu2">
                    <ul class="nav flex-column sub-menu mt-2">
                        <li class="nav-item"><a
                                class="nav-link {{ request()->routeIs('vendor-media-gallary') ? 'active' : '' }}"
                                href="{{ route('vendor-media-gallary', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Media Gallery</a></li>
                    </ul>
                </div>
            </li>

            <!-- Accommodation Inventory Menu -->
            @if (trim(strtolower($vendor->vendor_type)) == 'accommodation')
                <li class="nav-item my-1">
                    <a class="nav-link" data-bs-toggle="collapse" href="#menu3" role="button"
                        aria-expanded="{{ request()->routeIs('vendor-booking-utility', 'inventory-management', 'vendor-pricing', 'vendor-inquiries', 'vendor-transactions') ? 'true' : 'false' }}"
                        aria-controls="menu3">
                        <div><i class="fas fa-cogs menu-icon"></i> Accommodation Inventory</div>
                        <i
                            class="fas fa-angle-right expand-icon {{ request()->routeIs('vendor-booking-utility', 'inventory-management', 'vendor-pricing', 'vendor-inquiries', 'vendor-transactions') ? 'rotate' : '' }}"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('vendor-booking-utility', 'inventory-management', 'vendor-pricing', 'vendor-inquiries', 'vendor-transactions') ? 'show' : '' }}"
                        id="menu3">
                        <ul class="nav flex-column sub-menu mt-2">
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('vendor-booking-utility') ? 'active' : '' }}"
                                    href="{{ route('vendor-booking-utility', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Booking Utility</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('inventory-management') ? 'active' : '' }}"
                                    href="{{ route('inventory-management', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Inventory</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('vendor-pricing') ? 'active' : '' }}"
                                    href="{{ route('vendor-pricing', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Pricing</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('vendor-inquiries') ? 'active' : '' }}"
                                    href="{{ route('vendor-inquiries', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Booking Inquiries</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('vendor-transactions') ? 'active' : '' }}"
                                    href="{{ route('vendor-transactions', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Booking Transaction</a></li>
                        </ul>
                    </div>
                </li>
            @endif

            <!-- Sales & Orders Menu -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu4" role="button"
                    aria-expanded="{{ request()->routeIs('vendor-wines.index', 'winery.shop.orders', 'winery-shop.index', 'winery.vendor.orders') ? 'true' : 'false' }}"
                    aria-controls="menu4">
                    <div><i class="fas fa-cogs menu-icon"></i> Wine Catalogue (B2B)</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('vendor-wines.index', 'winery.shop.orders', 'winery-shop.index', 'winery.vendor.orders') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('vendor-wines.index', 'winery.shop.orders', 'winery-shop.index', 'winery.vendor.orders') ? 'show' : '' }}"
                    id="menu4">
                    <ul class="nav flex-column sub-menu mt-2">
                        @if (strtolower($vendor->vendor_type) == 'winery')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('vendor-wines.index') ? 'active' : '' }}"
                                    href="{{ route('vendor-wines.index', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Inventory
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('winery.shop.orders') ? 'active' : '' }}"
                                    href="{{ route('winery.shop.orders', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Order History
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('winery-shop.index') ? 'active' : '' }}"
                                    href="{{ route('winery-shop.index', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Purchase
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('winery.vendor.orders') ? 'active' : '' }}"
                                    href="{{ route('winery.vendor.orders', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Order History
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
            <!-- Parent Menu 5 -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu5" role="button"
                    aria-expanded="{{ request()->routeIs('vendor-amenities', 'vendor-curated-experience') ? 'true' : 'false' }}"
                    aria-controls="menu5">
                    <div><i class="fas fa-cogs menu-icon"></i> Amenities & Experiences</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('vendor-amenities', 'vendor-curated-experience') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('vendor-amenities', 'vendor-curated-experience') ? 'show' : '' }}"
                    id="menu5">
                    <ul class="nav flex-column sub-menu mt-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-amenities') ? 'active' : '' }}"
                                href="{{ route('vendor-amenities', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Amenities
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-curated-experience') ? 'active' : '' }}"
                                href="{{ route('vendor-curated-experience', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Curated Experience
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Parent Menu 6 -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu6" role="button"
                    aria-expanded="{{ request()->routeIs('reviews-testimonial', 'vendor-faqs') ? 'true' : 'false' }}"
                    aria-controls="menu6">
                    <div><i class="fas fa-cogs menu-icon"></i> Vendor Interaction</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('reviews-testimonial', 'vendor-faqs') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('reviews-testimonial', 'vendor-faqs') ? 'show' : '' }}"
                    id="menu6">
                    <ul class="nav flex-column sub-menu mt-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reviews-testimonial') ? 'active' : '' }}"
                                href="{{ route('reviews-testimonial', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Reviews & Testimonials
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-faqs') ? 'active' : '' }}"
                                href="{{ route('vendor-faqs', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> FAQ
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Parent Menu 7 -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu7" role="button"
                    aria-expanded="{{ request()->routeIs('subscription.index') ? 'true' : 'false' }}"
                    aria-controls="menu7">
                    <div><i class="fas fa-cogs menu-icon"></i> Subscription Management</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('subscription.index') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('subscription.index') ? 'show' : '' }}" id="menu7">
                    <ul class="nav flex-column sub-menu mt-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('subscription.index') ? 'active' : '' }}"
                                href="{{ route('subscription.index', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Subscription Plans
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-wrench menu-icon"></i> Active Subscriptions
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Parent Menu 8 -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu8" role="button"
                    aria-expanded="{{ request()->routeIs('vendor-settings', 'business-hours.index') ? 'true' : 'false' }}"
                    aria-controls="menu8">
                    <div><i class="fas fa-cogs menu-icon"></i> Operational Settings</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('vendor-settings', 'business-hours.index') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('vendor-settings', 'business-hours.index', 'stripe.details.show') ? 'show' : '' }}"
                    id="menu8">
                    <ul class="nav flex-column sub-menu mt-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-settings') ? 'active' : '' }}"
                                href="{{ route('vendor-settings', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> General Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('stripe.details.show') ? 'active' : '' }}"
                                href="{{ route('stripe.details.show', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i>Vendor Stripe Details
                            </a>
                        </li>
                        @if (strtolower($vendor->vendor_type) != 'accommodation')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('business-hours*') ? 'active' : '' }}"
                                    href="{{ route('business-hours.index', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Business Hours
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>