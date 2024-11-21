@php
    // Check if 'id' exists in the current URL
    $id = request()->route('vendorid');
    $vendor = getVendor($id);
@endphp

<div class="col-auto px-0 ms-3 left-navbar">
    <div class="d-flex flex-column align-items-center align-items-sm-start text-white"> <!--min-vh-100-->
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <div class="side-head w-100 p-3 mb-1 rounded-top" style="background-color: #348a96; color: white;">
                <h6 class="mb-0 fw-bold">Vendor Dashboard</h6>
            </div>
            <li class="nav-item {{ request()->is('vendor-dashboard*') ? 'active' : '' }}">
                <a href="{{ route('vendor-dashboard', ['vendorid' => $id]) }}" class="nav-link align-middle px-2">
                    <img src="{{ asset('images/icons/profile_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/profile_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                </a>
            </li>
            {{-- <li class="nav-item {{ request()->is('vendor-contact-detail*') ? 'active' : '' }}">
              <a href="{{ route('vendor-contact-detail', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                  <img src="{{ asset('images/icons/vendor_contact_icon_grey.png') }}" data-image="{{ asset('images/icons/vendor_contact_icon') }}">
                  <span class="ms-1 d-none d-sm-inline">Vendor Contact Details</span>
              </a>
          </li> --}}
          
            <li class="nav-item {{ request()->is('vendor-media-gallary*') ? 'active' : '' }}">
                <a href="{{ route('vendor-media-gallary', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/media_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/media_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Media Gallary</span>
                </a>
            </li>
            @if (trim(strtolower($vendor->vendor_type)) == 'accommodation')
            <li class="nav-item {{ request()->is('inventory-management*') ? 'active' : '' }}">
                <a href="{{ route('inventory-management', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/inventory_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/inventory_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Inventory Management</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('vendor-pricing*') ? 'active' : '' }}">
                <a href="{{ route('vendor-pricing', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/pricing_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/pricing_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Pricing</span>
                </a>
            </li>
            @if(trim($vendor->inventory_type) == 'Rooms')
            <li class="nav-item {{ request()->is('manage.rooms*') ? 'active' : '' }}">
                <a href="{{ route('manage.rooms', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/pricing_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/pricing_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Manage Rooms</span>
                </a>
            </li>
            @endif
            <li class="nav-item {{ request()->is('vendor-booking-utility*') ? 'active' : '' }}">
                <a href="{{ route('vendor-booking-utility', ['vendorid' => $id]) }}"
                    class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/booking_unity_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/booking_unity_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Booking Utility</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('vendor/inquiries*') ? 'active' : '' }}">
                <a href="{{ route('vendor-inquiries', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/booking_unity_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/booking_unity_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Booking Inquiries</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('vendor/transactions*') ? 'active' : '' }}">
                <a href="{{ route('vendor-transactions', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/booking_unity_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/booking_unity_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Transactions</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('vendor-amenities*') ? 'active' : '' }}">
                <a href="{{ route('vendor-amenities', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/Groupamenities_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/Groupamenities') }}">
                    <span class="ms-1 d-none d-sm-inline">Amenities</span>
                </a>
            </li>
            @endif
            <li class="nav-item {{ request()->is('winery-shop*') ? 'active' : '' }}">
                <a href="{{ route('winery-shop.index', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/booking_unity_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/booking_unity_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Winery Shop</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('winery-orders/shop*') ? 'active' : '' }}">
                <a href="{{ route('winery.shop.orders', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/booking_unity_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/booking_unity_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Winery Shop Orders</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('winery-orders/vendor*') ? 'active' : '' }}">
                <a href="{{ route('winery.vendor.orders', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/booking_unity_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/booking_unity_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Winery Vendor Orders</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('vendor-curated-experience*') ? 'active' : '' }}">
                <a href="{{ route('vendor-curated-experience', ['vendorid' => $id]) }}"
                    class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/curated_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/curated_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Curated Experience</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('reviews-testimonial*') ? 'active' : '' }}">
                <a href="{{ route('reviews-testimonial', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/review_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/review_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Review and Testimonial</span>
                </a>
            </li>
            @if(strtolower($vendor->vendor_type) != 'accommodation')
            <li class="nav-item {{ request()->is('business-hours*') ? 'active' : '' }}">
                <a href="{{ route('business-hours.index', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/vendor_settings_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/vendor_settings_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Business Hours</span>
                </a>
            </li>
            @endif
            @if(strtolower($vendor->vendor_type) == 'winery')
            <li class="nav-item {{ request()->is('vendor-wines*') ? 'active' : '' }}">
                <a href="{{ route('vendor-wines.index', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/vendor_settings_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/vendor_settings_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Wine Catalogue</span>
                </a>
            </li>
            @endif
            <li class="nav-item {{ request()->is('vendor-faqs*') ? 'active' : '' }}">
                <a href="{{ route('vendor-faqs', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/vendor_settings_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/vendor_settings_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">FAQs</span>
                </a>
            </li>
            {{-- <li class="nav-item {{ request()->is('winery-subscription*') ? 'active' : '' }}">
                <a href="{{ route('winery-subscription', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/vendor_settings_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/vendor_settings_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Winery Subscription</span>
                </a>
            </li> --}}
            <li class="nav-item {{ request()->is('vendor-settings*') ? 'active' : '' }}">
                <a href="{{ route('vendor-settings', ['vendorid' => $id]) }}" class="nav-link px-2 align-middle">
                    <img src="{{ asset('images/icons/vendor_settings_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/vendor_settings_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>
