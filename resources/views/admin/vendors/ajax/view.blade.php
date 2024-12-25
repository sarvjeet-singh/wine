<div class="tab-pane fade show active" id="tab-pane-view" role="tabpanel" aria-labelledby="tab-view" tabindex="0">
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">{{ ucfirst($vendor->vendor_type) ?? '' }}</div>
            </div>
        </div>
        <div class="m-3 pt-3">
            <div class="row g-4 align-items-center">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h4 class="fw-bold">Business Information</h4>
                        <p class="mb-1"><span class="fw-bold">Business/Vendor Name:</span>
                            {{ $vendor->vendor_name ?? '' }}</p>
                        <p class="mb-1"><span class="fw-bold">Street Address:</span>
                            {{ $vendor->street_address ?? '' }}</p>
                        <p class="mb-1"><span class="fw-bold">Sub -Region:</span>
                            {{ $vendor->sub_regions->name ?? '' }}
                        </p>
                        <p class="mb-1"><span class="fw-bold">City Town</span> {{ $vendor->city ?? '' }}</p>
                    </div>
                    <div>
                        <h4 class="fw-bold">Vendor Contact</h4>
                        <p class="mb-1"><span class="fw-bold">First Name:</span> {{ $vendor->user->firstname ?? '' }}
                            {{ $vendor->user->lastname ?? '' }}
                        </p>
                        <p class="mb-1"><span class="fw-bold">Email Address:</span>
                            {{ $vendor->user->email ?? '' }}</p>
                        {{-- <p class="mb-1"><span class="fw-bold">Title:</span> Manager</p> --}}
                        <p class="mb-1"><span class="fw-bold">Phone Number:</span>
                            {{ $vendor->user->contact_number ?? '' }}
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <p class="mb-1"><span class="fw-bold">Account Status: </span>
                            {{ $vendor->accountStatus->name ?? '' }}
                        </p>
                        <p class="mb-1"><span class="fw-bold">Sub Category: </span>Entire
                            home
                        </p>
                        <p class="mb-1"><span class="fw-bold">Provision/State:
                            </span>{{ $vendor->state->name ?? '' }}</p>
                    </div>
                    <div class="my-4">
                        <h4><span class="fw-bold">Price Rating:</span> $</h4>
                    </div>
                    <div class="social-links">
                        <h6 class="mb-3">Social media </h6>
                        <ul class="list-unstyled d-flex align-items-center gap-3">
                            @if ($vendor->socialMedia->facebook)
                                <li>
                                    <a target="_blank" href="{{ $vendor->socialMedia->facebook ?? '#' }}">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($vendor->socialMedia->instagram)
                                <li>
                                    <a target="_blank" href="{{ $vendor->socialMedia->instagram ?? '#' }}">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($vendor->socialMedia->twitter)
                                <li>
                                    <a target="_blank" href="{{ $vendor->socialMedia->twitter ?? '#' }}">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($vendor->socialMedia->youtube)
                                <li>
                                    <a target="_blank" href="{{ $vendor->socialMedia->youtube ?? '#' }}">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($vendor->socialMedia->pinterest)
                                <li>
                                    <a target="_blank" href="{{ $vendor->socialMedia->pinterest ?? '#' }}">
                                        <i class="fa-brands fa-pinterest"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($vendor->socialMedia->tiktok)
                                <li>
                                    <a target="_blank" href="{{ $vendor->socialMedia->tiktok ?? '#' }}">
                                        <i class="fa-brands fa-tiktok"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="view-tab-images d-flex align-items-center gap-3">
                        <img src="{{ $vendor->qr_code ? url($vendor->qr_code) : '' }}" class="img-fluid" />
                        <i class="fa-solid fa-cloud-arrow-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
