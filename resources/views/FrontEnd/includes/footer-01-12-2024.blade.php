<footer class="pt-4 border-top">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <ul
                    class="footer-links list-unstyled d-sm-flex justify-content-center align-items-center gap-4 px-0 mb-4">
                    <li class="mb-sm-0 mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a>
                    </li>
                    <li class="mb-sm-0 mb-2"><a
                            @if(!authCheck()['is_logged_in']) href="{{ route('register') }}" @else href="{{ route('guest-rewards') }}" @endif
                            class="text-decoration-none text-dark">Guest Rewards</a></li>
                    <li class="mb-sm-0 mb-2"><a href="{{ route('about-us') }}"
                            class="text-decoration-none text-dark">About Us</a></li>
                    <li class=""><a href="{{ route('contact-us') }}"
                            class="text-decoration-none text-dark">Contact Us</a></li>
                </ul>
                <div class="social text-md-start text-center">
                    <ul class="list-unstyled px-0 d-flex align-items-center justify-content-center gap-xl-3 gap-2 mb-0">
                        <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-tiktok"></i></a></li>
                    </ul>
                </div>

                <div class="sec-btn mt-4">
                    @if(!authCheck()['is_logged_in'])
                        <a href="{{ route('check-login') }}" class="btn theme-btn">
                            Promote a Business
                        </a>
                    @else
                        <a href="{{ route('become-vendor') }}" class="btn theme-btn">Promote a Business</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="bg-black copyright text-center py-3 mt-4">
        <p class="mb-0 text-white">Copyright © 2021 <span>Wine Country Weekends</span> | Powered by Wine Country
            Weekends</p>
    </div>
</footer>
<div class="modal fade" id="loginPopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="f-15">You must be logged-in to access this content</p>
                <h3 class="fs-4 fw-bold mb-4 theme-color">Login</h3>
                <form method="" action="">
                    <div class="form-field mb-2 position-relative">
                        <input type="text" class="form-control" placeholder="Enter Your Email" id="email">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="form-field mb-2 position-relative">
                        <input type="password" class="form-control" placeholder="Password" id="pwd">
                        <i class="fa-solid fa-unlock"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between my-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="Hotel">
                            <label class="form-check-label f-15" for="Hotel">
                                Remember Me
                            </label>
                        </div>
                        <a href="#" class="f-15 text-decoration-none">Forgot Password?</a>
                    </div>
                    <div>
                        <button type="submit" class="btn theme-btn w-100">Login</button>
                        <p class="my-3">OR</p>
                        <p class="f-15">Join Our <a href="#" class="text-decoration-none theme-color">Guest
                                Rewards</a> Program</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var header = document.querySelector('header');
    onScroll = () => {
        var scrolledPage = Math.round(window.pageYOffset);
        if (scrolledPage > 60) {
            header.classList.add('sticky');
        } else {
            header.classList.remove('sticky');
        }
    }

    document.addEventListener('scroll', onScroll);
</script>
<!-- /Header Scroll JS -->

<script></script>
