<div class="tab-pane fade show active payment-integration-tab" id="tab-pane-vendor-stripe" role="tabpanel"
    aria-labelledby="tab-pane-vendor-stripe" tabindex="0">
    <!-- Business Information -->
    <div class="info-head p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-white">Payment Integration</div>
            <div class="d-flex align-items-center justify-content-end gap-2">
                <div class="">
                    <a href="#" class="" data-bs-toggle="modal" data-bs-target="#videoSetupModal">
                        <i class="fa-solid fa-file-video"></i>
                    </a>
                </div>
                <div class="">
                    <a href="#" class="" data-bs-toggle="modal" data-bs-target="#GuideModal">
                        <i class="fa-solid fa-file-arrow-down"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column align-items-center gap-2">
        @if (empty($vendor->stripe_account_id))
            <h4>Still pending from Vendor side</h4>
        @else
            <div class="text-center">
                <h4>Stripe Connect ID - {{ $vendor->stripe_account_id }}</h4>
                <h4>Stripe Connect Account Status -
                    @if ($vendor->stripe_onboarding_account_status === 'active')
                        Active
                    @elseif ($vendor->stripe_onboarding_account_status === 'restricted')
                        Restricted
                    @elseif ($vendor->stripe_onboarding_account_status === 'pending_verification')
                        Pending Verification
                    @else
                        In Progress
                    @endif
                </h4>
            </div>
        @endif
    </div>
</div>
