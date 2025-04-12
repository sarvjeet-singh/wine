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
                <a class="nav-link {{ request()->routeIs('vendor-dashboard') ? 'active' : '' }}"
                    href="{{ route('vendor-dashboard', ['vendorid' => $id]) }}">
                    <div><i class="fas fa-folder-open menu-icon"></i> Profile Summary</div>
                </a>
            </li>

            <!-- Content Management Menu -->
            <li class="nav-item my-1">
                <a class="nav-link {{ request()->routeIs('vendor-media-gallary') ? 'active' : '' }}"
                    href="{{ route('vendor-media-gallary', ['vendorid' => $id]) }}">
                    <div><i class="fas fa-cogs menu-icon"></i> Media Gallery</div>
                </a>
            </li>

            <!-- Accommodation Inventory Menu -->
            @if (trim(strtolower($vendor->vendor_type)) == 'accommodation')
                <li class="nav-item my-1">
                    <a class="nav-link" data-bs-toggle="collapse" href="#menu3" role="button"
                        aria-expanded="{{ request()->routeIs('inventory-management', 'vendor-pricing', 'vendor-inquiries', 'vendor-transactions') ? 'true' : 'false' }}"
                        aria-controls="menu3">
                        <div><i class="fas fa-cogs menu-icon"></i> Accommodation Inventory</div>
                        <i
                            class="fas fa-angle-right expand-icon {{ request()->routeIs('inventory-management', 'vendor-pricing', 'vendor-inquiries', 'vendor-transactions') ? 'rotate' : '' }}"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('inventory-management', 'vendor-pricing', 'vendor-inquiries', 'vendor-transactions') ? 'show' : '' }}"
                        id="menu3">
                        <ul class="nav flex-column sub-menu mt-2">
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

            <!-- Parent Menu 5 -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu5" role="button"
                    aria-expanded="{{ request()->routeIs('vendor-amenities', 'vendor-curated-experience') ? 'true' : 'false' }}"
                    aria-controls="menu5">
                    <div><i class="fas fa-cogs menu-icon"></i> Guest Services</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('vendor-amenities', 'vendor-curated-experience', 'vendor.events-transactions') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('vendor-amenities', 'curative-experiences.index', 'vendor.events-transactions') ? 'show' : '' }}"
                    id="menu5">
                    <ul class="nav flex-column sub-menu mt-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-amenities') ? 'active' : '' }}"
                                href="{{ route('vendor-amenities', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Amenities
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('curative-experiences.index') ? 'active' : '' }}"
                                href="{{ route('curative-experiences.index', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Curated Experiences
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor.events-transactions') ? 'active' : '' }}"
                                href="{{ route('vendor.events-transactions', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Events History
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
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
                                <a class="nav-link {{ request()->routeIs('winery-shop.index') ? 'active' : '' }}"
                                    href="{{ route('winery-shop.index', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Purchases
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('vendor-wines.index') ? 'active' : '' }}"
                                    href="{{ route('vendor-wines.index', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Manage Inventory
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('winery.shop.orders') ? 'active' : '' }}"
                                    href="{{ route('winery.shop.orders', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Sales History
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('winery.vendor.orders') ? 'active' : '' }}"
                                    href="{{ route('winery.vendor.orders', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Purchase History
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('winery-shop.index') ? 'active' : '' }}"
                                    href="{{ route('winery-shop.index', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Purchases
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('winery.vendor.orders') ? 'active' : '' }}"
                                    href="{{ route('winery.vendor.orders', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i> Purchase History
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
            <li class="nav-item my-1">
                <a class="nav-link {{ request()->routeIs('subscription.index') ? 'active' : '' }}"
                    href="{{ route('subscription.index', ['vendorid' => $id]) }}">
                    <i class="fas fa-wrench menu-icon"></i> Subscription Plans
                </a>
            </li>
            <!-- Parent Menu 6 -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu6" role="button"
                    aria-expanded="{{ request()->routeIs('reviews-testimonial', 'vendor-referrals') ? 'true' : 'false' }}"
                    aria-controls="menu6">
                    <div><i class="fas fa-cogs menu-icon"></i> Manage Engagements</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('reviews-testimonial', 'vendor-referrals') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('reviews-testimonial', 'vendor-referrals') ? 'show' : '' }}"
                    id="menu6">
                    <ul class="nav flex-column sub-menu mt-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-referrals') ? 'active' : '' }}"
                                href="{{ route('vendor-referrals', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i>Referrals
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reviews-testimonial') ? 'active' : '' }}"
                                href="{{ route('reviews-testimonial', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i>Testimonials & Reviews
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item my-1">
                <a class="nav-link {{ request()->routeIs('vendor-faqs') ? 'active' : '' }}"
                    href="{{ route('vendor-faqs', ['vendorid' => $id]) }}">
                    <i class="fas fa-wrench menu-icon"></i>FAQs
                </a>
            </li>
            <!-- Parent Menu 8 -->
            <li class="nav-item my-1">
                <a class="nav-link" data-bs-toggle="collapse" href="#menu8" role="button"
                    aria-expanded="{{ request()->routeIs('vendor-booking-utility', 'vendor-settings', 'business-hours.index', 'stripe.details.show', 'vendor-social-media', 'vendor-change-password', 'vendor-access-credentials', 'vendor-questionnaire') ? 'true' : 'false' }}"
                    aria-controls="menu8">
                    <div><i class="fas fa-cogs menu-icon"></i> Operational Settings</div>
                    <i
                        class="fas fa-angle-right expand-icon {{ request()->routeIs('vendor-booking-utility', 'vendor-settings', 'business-hours.index', 'stripe.details.show', 'vendor-social-media', 'vendor-change-password', 'vendor-access-credentials', 'vendor-questionnaire') ? 'rotate' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->routeIs('vendor-booking-utility', 'vendor-settings', 'business-hours.index', 'stripe.details.show', 'vendor-social-media', 'vendor-change-password', 'vendor-access-credentials', 'vendor-questionnaire') ? 'show' : '' }}"
                    id="menu8">
                    <ul class="nav flex-column sub-menu mt-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-settings') ? 'active' : '' }}"
                                href="{{ route('vendor-settings', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> {{ ucfirst($vendor->vendor_type) }} Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-booking-utility') ? 'active' : '' }}"
                                href="{{ route('vendor-booking-utility', ['vendorid' => $id]) }}">
                                <i class="fas fa-cog menu-icon"></i> Transaction Parameters
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('stripe.details.show') ? 'active' : '' }}"
                                href="{{ route('stripe.details.show', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Payment Gateway
                            </a>
                        </li>
                        @if (strtolower($vendor->vendor_type) != 'accommodation')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('business-hours*') ? 'active' : '' }}"
                                    href="{{ route('business-hours.index', ['vendorid' => $id]) }}">
                                    <i class="fas fa-wrench menu-icon"></i>
                                    @if (strtolower($vendor->vendor_type) == 'winery')
                                        Business Hours
                                    @elseif(strtolower($vendor->vendor_type) == 'excursion')
                                        Box Office
                                    @else
                                        Business Hours
                                    @endif
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-access-credentials') ? 'active' : '' }}"
                                href="{{ route('vendor-access-credentials', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Vendor Contacts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-questionnaire') ? 'active' : '' }}"
                                href="{{ route('vendor-questionnaire', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Questionnaire
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-change-password') ? 'active' : '' }}"
                                href="{{ route('vendor-change-password', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Change Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor-social-media') ? 'active' : '' }}"
                                href="{{ route('vendor-social-media', ['vendorid' => $id]) }}">
                                <i class="fas fa-wrench menu-icon"></i> Social Media
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
