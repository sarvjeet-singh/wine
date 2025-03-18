@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')

<style>
.select2-container {
    width: 100% !important;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #dee2e6;
}
.select2-container .select2-selection--single {
    height: 37.6px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    padding-block: 4px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 6px;
}
</style>

    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">

                <!-- User Guest Registry Start -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex flex-wrap">
                                    <span class="box-head-label theme-color">Submit Reviews</span>
                                    <p class="f-15">Earn an additional $25 in Bottle Bucks after submitting ten (10) verifiable reviews (i.e. reviews include receipt#).</p>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form method="post" action="{{route('user-reviews-submit')}}">
                                    @csrf
                                    <input type="hidden" name="rating" value="0" id="rating">
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <label class="form-label">Business/Vendor Name<span class="required-filed">*</span></label>
                                            <select id="buisness_vendor_name" class="form-control @error('vendor_id') is-invalid @enderror" name="vendor_id" >
                                                <option value="" disabled selected>Select a vendor</option>
                                                @if($vendors)
                                                    @foreach($vendors as $vendor)
                                                        <option value="{{$vendor->id}}">{{$vendor->vendor_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('vendor_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-2">
                                            <label class="form-label">Date of Visit<span class="required-filed">*</span></label>
                                            <input type="date" class="form-control @error('date_of_visit') is-invalid @enderror" name="date_of_visit" max="{{ date('Y-m-d') }}">
                                            @error('date_of_visit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="email" class="form-label">Receipt#</label>
                                            <input type="text" placeholder="Receipt" class="form-control" name="receipt">
                                        </div>
                                    </div>

                                    <div class="row mt-3 mb-3">
                                        <div class="col-12">
                                            <div>
                                            <label class="form-label">Rate your experience from 1 - 5 stars<span class="required-filed">*</span></label>
                                            </div>
                                            <div class="my-rating-5"></div>
                                            @if ($errors->any())
                                                @foreach ($errors->get('rating') as $error)
                                                    <span class="is-invalid"></span>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $error }}</strong>
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mt-3 mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Describe your experience<span class="required-filed">*</span></label>
                                            <textarea class="form-control @error('review_description') is-invalid @enderror" placeholder="Description" id="exampleFormControlTextarea1" name="review_description" rows="3"></textarea>
                                            @error('review_description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn wine-btn">Submit</button>
                                        </div>
                                    </div>
                                </form>   
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Guest Registry End -->       
            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')
@endsection

@section('js')
<script>
    $("#buisness_vendor_name").select2();
    $(document).ready(function() {
		$(".my-rating-5").starRating({
			starSize: 20,
			hoverColor:'#c0a144',
			emptyColor:'#8b8b8b',
			callback:function(currentRating){
				// alert(currentRating);
				$("#rating").val(currentRating);
 			}
		});
        const dateInput = $('input[name="date_of_visit"]');
        dateInput.on('click', function() {
            this.showPicker();
        });
    });

</script>

@endsection