@extends('FrontEnd.layouts.mainapp')
@section('content')
    <style>
        .image-loader {
            width: 336px;
            height: 252px;
        }

        /* Loader styling */
        .fb-loader {
            width: 336px;
            height: 252px;
            background: linear-gradient(90deg,
                    #e0e0e0 20%,
                    /* Light Gray */
                    #f5f5f5 40%,
                    /* Soft White */
                    #e0e0e0 60%
                    /* Light Gray */
                );
            background-size: 200% 100%;
            animation: fbShimmer 1.5s infinite;
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Animation for loader */
        @keyframes fbShimmer {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: -100% 0;
            }
        }
    </style>
    <section class="curated-event-sec my-sm-5 my-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <div class="search-bar position-relative">
                            <input type="search" class="form-control rounded-5 py-2" placeholder="Search" name="search">
                            <button type="submit" class="btn border-0 p-0"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                        <div class="filter-bar">
                            <a href="#">
                                <i class="fa-solid fa-filter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt-3">
                @if (!empty($events) && count($events) > 0)
                    @foreach ($events as $event)
                        <div class="col-lg-4 col-sm-6">
                            <div class="event-card">

                                <div class="event-thumbnail position-relative">
                                    <div class="fb-loader"></div>
                                    <img src="https://images.unsplash.com/photo-1470116073782-48ae2ccd8ffd?ixlib=rb-1.2.1&auto=format&fit=crop&w=100"
                                        data-src="{{ Storage::url($event->medias[0]->file_path) }}" alt="Event Image"
                                        class="img-fluid image-loader lazyload" />
                                    <p class="event-date mb-0">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} {{\Carbon\Carbon::parse($event->start_time)->format('H:i A') }}
                                    </p>
                                </div>
                            </div>
                            <div class="event-info p-3">
                                <div class="d-flex align-items-center justify-content-between gap-1 mb-2">
                                    <h5 class="theme-color fw-bold mb-0">{{ $event->name }}</h5>
                                    <p class="event-price fw-bold mb-0">${{ $event->admittance }}{{ $event->extension }}</p>
                                </div>
                                <p class="event-desc">{{ Str::limit($event->description, 100) }}</p>
                                <a href="#" class="btn theme-btn px-3">Buy Now</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No events available.</p>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
    <script>
        $(document).ready(function() {
            $(".image-loader").on("load", function() {
                $(".fb-loader").remove(); // Hide the loader
            });
        });
    </script>
@endsection
