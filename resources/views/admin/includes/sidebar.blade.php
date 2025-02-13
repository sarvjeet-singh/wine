<div class="sidebar">
    <div class="sidebar-logo text-center px-3">
        <img src="{{ asset('asset/admin/images/logo-white.png') }}" class="img-fluid w-75 mb-3" alt="Logo" />
    </div>
    <div class="dash px-3 py-3 mb-3">
        <a href="#">
            <img src="{{ asset('asset/admin/images/icons/dashboard.png') }}" alt="Icon" />
            <span class="link_name">Admin Dashboard</span>
        </a>
    </div>
    <ul class="nav-links list-unstyled">
        <li class="position-relative parent-menu">
            <a href="#">
                <img src="{{ asset('asset/admin/images/icons/user-icon.png') }}">
                <span class="link_name">User Management</span>
            </a>
            <i class="fa-solid fa-angle-right"></i>
            <ul class="sub-menu list-unstyled mt-2">
                <li class="mb-2"><a href="user-listing.html">Manage Users</a></li>
                <li class="mb-2"><a href="">Profle Image Checks</a></li>
            </ul>
        </li>
        <li class="position-relative parent-menu">
            <a href="#">
                <img src="{{ asset('asset/admin/images/icons/management-icon.png') }}">
                <span class="link_name">Vendor management</span>
            </a>
            <i class="fa-solid fa-angle-right"></i>
            <ul class="sub-menu list-unstyled mt-2">
                <li class="mb-2"><a href="{{route('admin.vendors')}}">Manage Vendor</a></li>
                <li class="mb-2"><a href="{{route('admin.vendors.create')}}">Create vendor</a></li>
            </ul>
        </li>
        <li class="position-relative parent-menu">
            <a href="#">
                <img src="{{ asset('asset/admin/images/icons/management-icon.png') }}">
                <span class="link_name">Content Management</span>
            </a>
            <i class="fa-solid fa-angle-right"></i>
            <ul class="sub-menu list-unstyled mt-2">
                <li class="mb-2"><a href="{{route('admin.faqs.index')}}">Manage FAQs</a></li>
                <li class="mb-2"><a href="">Manage Terms & Condition</a></li>
                <li class="mb-2"><a href="">Manage Questionnaire</a></li>
            </ul>
        </li>
        <li class="position-relative parent-menu">
            <a href="#">
                <img src="{{ asset('asset/admin/images/icons/setting-icon.png') }}">
                <span class="link_name">Settings</span>
            </a>
            <i class="fa-solid fa-angle-right"></i>
            <ul class="sub-menu list-unstyled mt-2">
                <li class="mb-2"><a href="">Manage Filter</a></li>
                <li class="mb-2"><a href="">Manage Amenities</a></li>
                <li class="mb-2"><a href="">Manage Role</a></li>
                <li class="mb-2"><a href="">Change Password</a></li>
            </ul>
        </li>
        <li class="position-relative">
            <a href="{{route('admin.reviews')}}">
                <img src="{{ asset('asset/admin/images/icons/faq-icon.png') }}">
                <span class="link_name">Manage Review & Testimonial</span>
            </a>
        </li>
        <li class="position-relative">
            <a href="{{route('admin.plans.index')}}">
                <img src="{{ asset('asset/admin/images/icons/faq-icon.png') }}">
                <span class="link_name">Manage Stripe Plans</span>
            </a>
        </li>
        <li class="position-relative">
            <a href="{{route('admin.taxes.index')}}">
                <img src="{{ asset('asset/admin/images/icons/faq-icon.png') }}">
                <span class="link_name">Manage Stripe Taxes</span>
            </a>
        </li>
        <li class="position-relative">
            <a href="{{route('admin.wallet.index')}}">
                <img src="{{ asset('asset/admin/images/icons/faq-icon.png') }}">
                <span class="link_name">Manage Bottle Bucks</span>
            </a>
        </li>
        <li class="position-relative">
            <a href="{{route('admin.configuration-settings')}}">
                <img src="{{ asset('asset/admin/images/icons/faq-icon.png') }}">
                <span class="link_name">Configuration Settings </span>
            </a>
        </li>
    </ul>
</div>
