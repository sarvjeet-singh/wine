@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="col right-side">
        <table id="review-testimonial" class="display stripe cell-border table-custom" style="width:100%">
            <thead>
                <tr>
                    <th>Profile</th>
                    <th>Date of Visits</th>
                    <th>Receipts</th>
                    <th>User Name</th>
                    <th>Comment</th>
                    <th>Ratings</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $key => $review)
                    <tr>
                        <td>
                            <img class="userprofile-image-icon"
                                src="{{ asset('images/UserProfile/' . ($review->customer->profile_image ?? 'default-profile.png')) }}"
                                alt="User Profile">
                        </td>
                        <td>{{ $review->date_of_visit }}</td>
                        <td>{{ $review->receipt }}</td>
                        <td>{{ $review->customer->firstname ?? '' }} {{ $review->customer->lastname ?? '' }}</td>
                        <td>{!! truncateReviewDescription($review->review_description) !!}</td>
                        <td>
                            <div class="star-rating" data-rating="{{ $review->rating }}" id="rating_{{ $key }}"></div>
                        </td>
                        <td>{{ $review->review_status }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="readMoreModal" tabindex="-1" aria-labelledby="readMoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title theme-color" id="readMoreModalLabel">Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body px-4">
                    <p id="modal-full-text"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Modal -->
@endsection
@section('js')
    <script>
        $(document).ready(function(e) {
            let table = new DataTable('#review-testimonial');

            $('.star-rating').starRating({
                readOnly: true,
                initialRating: function(index, el) {
                    // Set the initial rating based on your data
                    return parseFloat($(el).attr('data-rating'));
                },
                starSize: 15
            });
        });
        // Event delegation for the Read More buttons using .delegate()
        $(document).delegate('.read-more', 'click', function(event) {
            event.preventDefault();
            var fullText = $(this).attr('data-full-text');
            $('#modal-full-text').text(fullText);
            $('#readMoreModal').modal('show');
        });
    </script>
@endsection
