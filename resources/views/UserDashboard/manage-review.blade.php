@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
<div class="container main-container">
    <div class="row flex-lg-nowrap flex-wrap g-4">
        @include('UserDashboard.includes.leftNav')
        <div class="col right-side">
            <div class="table-responsive">
            <table id="managereviews" class="display stripe cell-border table-custom" style="width:100%">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Receipts</th>
                        <th>Vendor Name</th>
                        <th>Street Address</th>
                        <th>Date of Visits</th>
                        <th>Comment</th>                          
                        <th>Ratings</th>                        
                    </tr>
                </thead>
                <tbody>
                    @if($reviews)
                        @foreach($reviews as $key =>$review)
                        <tr>
                            <td>{{$review->review_status}}</td>
                            <td>{{$review->receipt ? "#".$review->receipt : ''}}</td>
                            <td>{{$review->vendor->vendor_name}}</td>
                            <td>{{$review->vendor->street_address}}</td>
                            <td>{{$review->date_of_visit}}</td>
                            <td>
                                {!! truncateReviewDescription($review->review_description) !!}
                            </td>                            
                            <td>
                                <div class="star-rating" data-rating="{{$review->rating}}" id="rating_{{$key}}"></div>
                            </td>                
                        </tr>
                        @endforeach
                    @endif
                
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@include('UserDashboard.includes.logout_modal')
<!-- Bootstrap Modal -->
<div class="modal fade" id="readMoreModal" tabindex="-1" aria-labelledby="readMoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title theme-color" id="readMoreModalLabel">Comment view</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
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
        let table = new DataTable('#managereviews');

        $('.star-rating').starRating({
            readOnly: true,
            initialRating: function(index, el) {
                // Set the initial rating based on your data
                return parseFloat($(el).attr('data-rating'));
            },
            starSize: 15
        });

        // Event delegation for the Read More buttons using .delegate()
        $(document).delegate('.read-more', 'click', function(event) {
            event.preventDefault();
            var fullText = $(this).attr('data-full-text');
            $('#modal-full-text').text(fullText);
            $('#readMoreModal').modal('show');
        });
    });
</script>

@endsection