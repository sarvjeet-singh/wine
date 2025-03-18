<style>
li.nav-item ul.sub-menu-list {
    display: none;
    padding-inline: 10px;
}
li.nav-item:has(.enable-sub-menu) ul.sub-menu-list {
    display: block;
}
.left-navbar li.nav-item ul.sub-menu-list a {
    color: #757575;
    background-color: unset;
    display: block;
    padding: 4px 30px;
    border-radius: 4px;
}
.left-navbar .nav-item ul.sub-menu-list li:hover a {
    background-color: #bba253;
    color: #fff;
}
li.nav-item svg {
    position: absolute;
    top: 15px;
    right: 10px;
}
li.nav-item.active {
    background-color: unset !important;
}
li.nav-item.active a.nav-link {
    background-color: #bba253;
    color: #fff;
}
</style>

<div class="left-navbar-mobile d-lg-none d-flex align-items-center justify-content-between py-2">
    <h6 class="mb-0 fw-bold text-dark">User Dashboard</h6>
    <nav class="navbar w-25 border-0">
        <div class="container-fluid justify-content-end">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#leftNavbarMobile"
                aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</div>

<div class="col-lg-auto col-lg-3 col-xl-3 px-0 left-navbar collapse" id="leftNavbarMobile">
    <div class="d-flex flex-column align-items-center align-items-sm-start text-white inner-sec"> <!--min-vh-100-->
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <div class="side-head w-100 p-3 mb-1 rounded-top d-lg-block d-none">
                <h6 class="mb-0 fw-bold text-dark">User Dashboard</h6>
            </div>
            <li class="leftNavbar-cross-icon d-lg-none d-block">
                <div class="mob-cross text-end">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </li>
            <li class="nav-item {{ request()->is('user-dashboard*') ? 'active' : '' }}">
                <a href="{{ route('user-dashboard') }}" class="nav-link align-middle px-sm-2 px-3">
                    <img src="{{ asset('images/icons/profile_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/profile_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">My Profile</span>
                </a>
            </li>
            {{-- <li class="nav-item {{ request()->is('message*') ? 'active' : '' }}">
              <a href="#" class="nav-link px-sm-2 px-3 align-middle">
                  <img src="{{asset('images/icons/message_icon_grey.png')}}" data-image="{{asset('images/icons/message_icon') }}">
                  <span class="ms-1 d-none d-sm-inline">Messages</span>
              </a>
          </li> --}}

            <li class="nav-item {{ request()->is('user-review-submit*') ? 'active' : '' }}">
                <a href="{{ route('user-review-submit') }}" class="nav-link px-sm-2 px-3 align-middle">
                    <img src="{{ asset('images/icons/rating_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/rating_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Submit Reviews</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('user/wallet-history*') ? 'active' : '' }}">
                <a href="{{ route('wallet-history') }}" class="nav-link px-sm-2 px-3 align-middle">
                    <img src="{{ asset('images/icons/rating_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/rating_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Bottle Bucks History</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('vendor-suggest*') ? 'active' : '' }}">
                <a href="{{ route('vendorsuggest') }}" class="nav-link px-sm-2 px-3 align-middle">
                    <img src="{{ asset('images/icons/referral_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/referral_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Promote a Business</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('manage-review*') ? 'active' : '' }}">
                <a href="{{ route('manage-review') }}" class="nav-link px-sm-2 px-3 align-middle">
                    <img src="{{ asset('images/icons/manage_reviews_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/manage_reviews_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Manage Reviews</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('user/inquiries*') ? 'active' : '' }}">
                <a href="{{ route('user-inquiries') }}" class="nav-link px-sm-2 px-3 align-middle">
                    <img src="{{ asset('images/icons/tranctions_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/tranctions_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Booking Inquiries</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('user/transactions*') ? 'active' : '' }}">
                <a href="{{ route('user-transactions') }}" class="nav-link px-sm-2 px-3 align-middle">
                    <img src="{{ asset('images/icons/tranctions_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/tranctions_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">My Transactions</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('user-faq*') ? 'active' : '' }}">
                <a href="{{ route('user-faq') }}" class="nav-link px-sm-2 px-3 align-middle">
                    <img src="{{ asset('images/icons/faq_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/faq_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">User FAQs</span>
                </a>
            </li>
            <!-- <li class="nav-item">
              <a href="{{ route('user-referral') }}" class="nav-link px-sm-2 px-3 align-middle">
                  <img src="{{ asset('images/icons/referral_icon_grey.png') }}" data-image="{{ asset('images/icons/referral_icon') }}">
                  <span class="ms-1 d-none d-sm-inline">Referral</span>
              </a>
          </li> -->
          <!-- <li class="nav-item {{ request()->is('user-settings*') ? 'active' : '' }}">
                <a href="{{ route('user-settings') }}" class="nav-link px-sm-2 px-3 align-middle">
                    <img src="{{ asset('images/icons/settings_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/settings_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Settings</span>
                </a>
            </li> -->
            <li class="nav-item position-relative {{ request()->is('user-settings*') ? 'active' : '' }}" id="settingsDropdown">
                <a href="#" class="nav-link head-link px-sm-2 px-3 align-middle">
                    <img src="{{ asset('images/icons/settings_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/settings_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Settings</span>
                    <i class="fas fa-angle-right expand-icon"></i>
                </a>
                <ul class="sub-menu-list">
                    <li class="dropdown-item my-2"><a href="/user-settings">User Settings</a></li>
                    <li class="dropdown-item my-2"><a href="#">Another Action</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="javascripr:void(0)" class="nav-link px-sm-2 px-3 align-middle" data-bs-toggle="modal"
                    data-bs-target="#logoutModal">
                    <img src="{{ asset('images/icons/logout_icon_grey.png') }}"
                        data-image="{{ asset('images/icons/logout_icon') }}">
                    <span class="ms-1 d-none d-sm-inline">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.mob-cross').on('click', function() {
            $('.left-navbar').removeClass('show');
        });
    });
</script>

<script>
    $(document).ready(function() {
    // Toggle the 'enable-sub-menu' class only on the a.nav-link when clicked
    $('a.head-link').click(function(event) {
        event.preventDefault(); // Prevent default anchor link behavior

        // Toggle the 'enable-sub-menu' class on the clicked a.head-link only
        $(this).toggleClass('enable-sub-menu');

        // No longer toggle on the sub-menu-list here
    });

    // Close the dropdown when clicking anywhere outside the a.head-link
    $(document).click(function(event) {
        // If the click is outside the a.head-link, remove the enable-sub-menu class
        if (!$(event.target).closest('a.head-link').length) {
            // Remove 'enable-sub-menu' class from all a.head-link elements
            $('a.head-link').removeClass('enable-sub-menu');
        }
    });
});


</script>