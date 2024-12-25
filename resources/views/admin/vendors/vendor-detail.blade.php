@extends('admin.layouts.app')
@section('content')
    <style>
        #myTab {
            overflow-x: scroll;
            /* Enable horizontal scroll */
            -ms-overflow-style: none;
            /* For Internet Explorer */
            scrollbar-width: none;
            /* For Firefox */
        }

        #myTab::-webkit-scrollbar {
            display: none;
            /* Hide scrollbar for Webkit browsers (Chrome, Safari) */
        }

        /* Container for the tabs */
        .tab-container {
            position: relative;
            overflow: hidden;
            /* Hide the overflow */
            width: 100%;
            /* Adjust as needed */
        }

        /* Style for the tabs */
        #myTab {
            display: flex;
            overflow-x: scroll;
            /* Enable horizontal scroll */
            -ms-overflow-style: none;
            /* For Internet Explorer */
            scrollbar-width: none;
            /* For Firefox */
        }

        #myTab::-webkit-scrollbar {
            display: none;
            /* Hide scrollbar */
        }

        /* Left and Right Scroll Arrows */
        .scroll-left,
        .scroll-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(40, 64, 94, 0.8);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }

        .scroll-left {
            left: 10px;
        }

        .scroll-right {
            right: 10px;
        }

        .scroll-left:hover,
        .scroll-right:hover {
            background: rgba(40, 64, 94, 0.8);
        }

        .scroll-left i,
        .scroll-right i {
            font-size: 20px;
        }

        .skeleton-loader {
            display: flex;
            flex-direction: column;
            gap: 20px;
            /* Increase the space between items */
            padding: 20px;
            animation: pulse 1.5s infinite;
            max-width: 100%;
            height: 100vh;
            /* Ensures the loader is responsive */
        }

        .skeleton-header {
            height: 40px;
            /* Increased height for the header */
            width: 70%;
            /* Adjusted width for better look */
            background-color: #e0e0e0;
            border-radius: 8px;
        }

        .skeleton-line {
            height: 20px;
            /* Increased height for the lines */
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 8px;
        }

        .skeleton-line.short {
            width: 80%;
            /* Slightly reduced width for variety */
        }

        @keyframes pulse {
            0% {
                background-color: #e0e0e0;
            }

            50% {
                background-color: #f0f0f0;
            }

            100% {
                background-color: #e0e0e0;
            }
        }
    </style>
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Vendor Details</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"
                                            class="text-decoration-none text-black">User
                                            Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Listing</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="vendor-detail-tab-sec p-3">
                        <!-- Tab Section Start -->
                        <div class="tab-container">
                            <button class="scroll-left" id="scroll-left"><i class="fa fa-chevron-left"></i></button>
                            <ul class="nav nav-tabs border-0 light-bg" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-view" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-view" type="button" role="tab"
                                        aria-controls="tab-pane-view" aria-selected="true"
                                        data-url="{{ route('admin.vendor.details.ajax-view', $vendor->id) }}">View</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-wine-listing" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-wine-listing" type="button" role="tab"
                                        aria-controls="tab-pane-wine-listing" aria-selected="false">Wine Listing</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-vendor-detail" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-vendor-detail" type="button" role="tab"
                                        aria-controls="tab-pane-vendor-detail" aria-selected="false">Vendor Detail</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-media-gallery" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-media-gallery" type="button" role="tab"
                                        data-url="{{ route('admin.vendor.details.ajax-media-gallery', $vendor->id) }}"
                                        aria-controls="tab-pane-media-gallery" aria-selected="false">Media Gallery</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-booking-utility" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-booking-utility" type="button" role="tab"
                                        aria-controls="tab-pane-booking-utility" aria-selected="false">Booking
                                        Utility</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-inventory-management" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-inventory-management" type="button" role="tab"
                                        aria-controls="tab-pane-inventory-management" aria-selected="false">Inventory
                                        Management</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-pricing" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-pricing" type="button" role="tab"
                                        aria-controls="tab-pane-pricing" aria-selected="false">Pricing</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-booking-inquiries" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-booking-inquiries" type="button" role="tab"
                                        aria-controls="tab-pane-booking-inquiries" aria-selected="false">Booking
                                        Inquiries</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-booking-transaction" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-booking-transaction" type="button" role="tab"
                                        aria-controls="tab-pane-booking-transaction" aria-selected="false">Booking
                                        Transaction</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-amenties" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-amenties" type="button" role="tab"
                                        aria-controls="tab-pane-amenties" aria-selected="false">Amenties</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-curated-exp" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-curated-exp" type="button" role="tab"
                                        aria-controls="tab-pane-curated-exp"
                                        data-url="{{ route('admin.vendor.details.ajax-experience', $vendor->id) }}"
                                        aria-selected="false">Curated Experience</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-system-admin" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-system-admin" type="button" role="tab"
                                        aria-controls="tab-pane-system-admin" aria-selected="false">System Admin</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-setting" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-setting" type="button" role="tab"
                                        aria-controls="tab-pane-setting" aria-selected="false">Settings</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-questionnaire" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-questionnaire" type="button" role="tab"
                                        aria-controls="tab-pane-questionnaire"
                                        data-url="{{ route('admin.vendor.details.ajax-questionnaire', $vendor->id) }}"
                                        aria-selected="false">Questionnaire</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-access-credentials" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-access-credentials" type="button" role="tab"
                                        aria-controls="tab-pane-access-credentials"
                                        data-url="{{ route('admin.vendor.details.ajax-access-credentials', $vendor->id) }}"
                                        aria-selected="false">Access Credentials</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-social-media" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-social-media" type="button" role="tab"
                                        aria-controls="tab-pane-social-media"
                                        data-url="{{ route('admin.vendor.details.ajax-social-media', $vendor->id) }}"
                                        aria-selected="false">Social Media</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-vendor-stripe" data-bs-toggle="tab"
                                        data-bs-target="#tab-pane-vendor-stripe" type="button" role="tab"
                                        data-url="{{ route('admin.vendor.details.ajax-stripe', $vendor->id) }}"
                                        aria-controls="tab-pane-vendor-stripe" aria-selected="false">Stripe
                                        Details</button>
                                </li>
                            </ul>
                            <button class="scroll-right" id="scroll-right"><i class="fa fa-chevron-right"></i></button>
                        </div>
                        <!-- Tabs Content -->
                        <div class="tab-content my-4" id="myTabContent">
                            <!-- View Tab -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function loadTabContent(url, targetPane) {
            // Show Facebook-style skeleton loader
            $(targetPane).html(`
        <div class="skeleton-loader">
            <div class="skeleton-header"></div>
            <div class="skeleton-line"></div>
            <div class="skeleton-line"></div>
            <div class="skeleton-line short"></div>
        </div>
    `);

            // Perform the AJAX request
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $(targetPane).html(response); // Replace the loader with the fetched content
                },
                error: function() {
                    $(targetPane).html(
                        '<p class="text-danger">Error loading content. Please try again later.</p>');
                }
            });
        }
        $(document).ready(function() {
            // Handle tab clicks
            $('.nav-link').on('click', function() {
                const url = $(this).data('url'); // Get the URL to load
                const paneId = $(this).attr('aria-controls'); // Get the target pane
                const targetPane = '#myTabContent';

                if (url) {
                    loadTabContent(url, targetPane);

                    // Update browser history
                    // const state = {
                    //     paneId: paneId
                    // };
                    // history.pushState(state, null, url);
                }
            });

            // Handle back/forward navigation
            window.onpopstate = function(event) {
                if (event.state && event.state.paneId) {
                    const paneId = event.state.paneId;
                    $(`#${paneId}`).addClass('active show').siblings().removeClass('active show');
                    const url = $(`.nav-link[aria-controls="${paneId}"]`).data('url');
                    if (url) loadTabContent(url, `#${paneId}`);
                }
            };

            // Load tab content on page load based on URL
            const currentPaneId = new URLSearchParams(window.location.search).get('tab') || 'tab-pane-view';
            // const currentTab = $(`.nav-link[aria-controls="${currentPaneId}"]`);
            // if (currentTab.length) {
            //     currentTab.trigger('click');
            // }
        });
        $('.nav-link').on('click', function() {
            const paneId = $(this).attr('aria-controls');
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('tab', paneId);
            history.pushState({
                paneId: paneId
            }, null, currentUrl.toString());
        });
        $(document).ready(function() {
            $('#myTab').on('wheel', function(event) {
                // Prevent the default behavior of scrolling the page
                event.preventDefault();

                // Check if the user is scrolling up or down
                var scrollAmount = 50; // Adjust this value to control scroll speed
                if (event.originalEvent.deltaY > 0) {
                    // Scroll tabs to the right (forward)
                    $(this).scrollLeft($(this).scrollLeft() + scrollAmount);
                } else {
                    // Scroll tabs to the left (backward)
                    $(this).scrollLeft($(this).scrollLeft() - scrollAmount);
                }
            });
            // Function to check the overflow and hide arrows accordingly
            function checkArrowVisibility() {
                var scrollLeft = $('#myTab').scrollLeft();
                console.log($('#myTab').scrollLeft());
                var scrollWidth = $('#myTab')[0].scrollWidth;
                console.log(scrollWidth);
                var containerWidth = $('#myTab').outerWidth();
                console.log(containerWidth);
                // If scrolled to the left, hide the left arrow
                if (scrollLeft === 0) {
                    $('.scroll-left').hide();
                } else {
                    $('.scroll-left').show();
                }
                
                // If scrolled to the right, hide the right arrow
                if (scrollLeft + containerWidth + 2 >= scrollWidth) {
                    $('.scroll-right').hide();
                } else {
                    $('.scroll-right').show();
                }
            }

            // Scroll right when right arrow is clicked
            $('#scroll-right').click(function() {
                $('#myTab').animate({
                    scrollLeft: $('#myTab').scrollLeft() + 200
                }, 300, function() {
                    checkArrowVisibility(); // Check arrow visibility after scrolling
                });
            });

            // Scroll left when left arrow is clicked
            $('#scroll-left').click(function() {
                $('#myTab').animate({
                    scrollLeft: $('#myTab').scrollLeft() - 200
                }, 300, function() {
                    checkArrowVisibility(); // Check arrow visibility after scrolling
                });
            });

            // Initial check on page load to hide/show arrows based on scroll position
            checkArrowVisibility();

            // Optional: Check again when window is resized
            $(window).on('resize', function() {
                checkArrowVisibility();
            });

            // Optional: Check scroll position on tab content load if needed
            $('#myTab').on('scroll', function() {
                checkArrowVisibility(); // Check arrow visibility during scrolling
            });
            // Use the current URL's query parameters
            const searchParams = new URLSearchParams(window.location.search);

            if (searchParams.has('tab')) {
                const paneId = searchParams.get('tab');

                // Activate the tab pane
                $(`.nav-link[aria-controls="${paneId}"]`).addClass('active').siblings().removeClass('active');

                // Scroll the tab into view
                const tabElement = $(`.nav-link[aria-controls="${paneId}"]`);
                if (tabElement.length) {
                    tabElement[0].scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest',
                        inline: 'center'
                    });
                }

                // Load tab content based on the URL from data-url attribute
                const url = $(`.nav-link[aria-controls="${paneId}"]`).data('url');
                if (url) {
                    loadTabContent(url, `#myTabContent`);
                }
            } else {
                // Default behavior: load initial content into the main tab container
                loadTabContent('{{ route('admin.vendor.details.ajax-view', $vendor->id) }}', '#myTabContent');
                $(`.nav-link[aria-controls="tab-pane-view"]`).addClass('active').siblings().removeClass('active');
            }
        });
    </script>
@endpush
