@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Vendor Contact Details</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        <form>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="{{Auth::user()->firstname}}" placeholder="Enter first name">
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="{{Auth::user()->lastname}}" placeholder="Enter last name">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Email Address</label>
                                    <input type="text" class="form-control" name="email" value="{{Auth::user()->email}}" placeholder="Enter email address">
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control phone-number" name="contact_number" value="{{Auth::user()->contact_number}}" placeholder="Enter Phone number">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter Title">
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Position</label>
                                    <input type="text" class="form-control" name="position" placeholder="Enter Position">
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn wine-btn">Update</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.phone-number').forEach(function(input) {
            input.addEventListener('input', function(e) {
                const value = e.target.value.replace(/\D/g, ''); // Remove all non-digit characters
                let formattedValue = '';
                if (value.length > 3 && value.length <= 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3);
                } else if (value.length > 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                } else {
                    formattedValue = value;
                }
                e.target.value = formattedValue;
            });
        });
    });
</script>
@endsection