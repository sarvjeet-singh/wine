<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="logoutModalLabel">Logout</h5> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark close-icon"></i></button>
            </div>
            <div class="modal-body text-center">
                <img width=70 src="{{asset('images/icons/logout_modal_icon.png')}}" >
                <div class="mt-3" style="font-weight:500; font-size:22px;">
                    Logout
                </div>
                <div style="color:#757575">
                    Are you sure you want to logout?
                </div>

                <div class="mt-3">
                    
                    <button class="btn wine-btn" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</button>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                    <button class="btn wine-btn-cancel" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>


            </div>
        </div>
    </div>
</div>