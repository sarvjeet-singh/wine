@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="col right-side">
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="information-box payment-integration-sec">
                    <div class="information-box-head d-flex align-items-center justify-content-between">
                        <div class="box-head-heading">
                            <span class="box-head-label theme-color">Payment Integration</span>
                        </div>
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
                @if (empty($vendor->stripe_account_id))
                    <div class="d-flex align-content-center justify-content-center gap-2 mt-3">
                        <a href="{{ $oauthUrl }}" class="btn wine-btn">
                            Connect Stripe Account
                        </a>
                    </div>
                @else
                    <div class="d-flex flex-column align-content-center justify-content-center gap-2 mt-3">
                        <h4>Your account is connected successfully</h4>
                        <h5>Stripe Connect Account Status -
                            @if ($vendor->stripe_onboarding_account_status === 'active')
                                Active
                            @elseif ($vendor->stripe_onboarding_account_status === 'restricted')
                                Restricted
                            @elseif ($vendor->stripe_onboarding_account_status === 'pending_verification')
                                Pending Verification
                            @else
                                In Progress
                            @endif
                        </h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
