<header class="d-flex align-items-center justify-content-between text-white p-3">
    <!-- Left Side Header -->
    <div class="left-header-side d-flex align-items-center">
        <div class="welcome-head">
            <h3 class="mb-0">Welcome</h3>
            <p class="mb-0">Here's what's happening in your account</p>
        </div>
    </div>

    <!-- Center Section -->
    <div class="center-header text-center flex-grow-1">
        <h5 class="mb-0" id="vendorName"></h5>
    </div>

    <!-- Right Side Header -->
    <div class="right-side-header">
        <div class="account-header">
            <div class="dropdown">
                <button class="btn btn-account dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="account-user text-white d-flex align-items-center gap-3 text-start">
                        <img src="images/user-main.png" alt="User Image">
                        <div class="user-account-data">
                            <h6 class="f-16 mb-0 bold"><span>Hello,</span> John Doe</h6>
                            <p class="f-14 mb-0">Super Admin</p>
                        </div>
                        <a href="#"><i class="fa-solid fa-angle-down"></i></a>
                    </div>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
