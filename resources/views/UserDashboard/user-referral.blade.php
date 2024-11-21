@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="container main-container">
        <div class="row flex-nowrap">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">


                <!-- User Guest Registry Start -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Referral</span>
                                </div>
                                <div class="box-head-description mt-3">
                                    What caused you to join our community and Guest Rewards program?
                                </div>
                            </div>
                            <div class="information-box-body">
                                <form>
                                    <div class="row mt-3">
                                        <div class="col-sm-4 col-12">
                                            <input type="checkbox" class="custom-checkbox" id="search_engine">
                                            <label for="search_engine">Search Engine Results</label>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <input type="checkbox" class="custom-checkbox" id="list_vendors">
                                            <label for="list_vendors">Niagara Region Vendor</label>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <input type="checkbox" class="custom-checkbox" id="local_vendor">
                                            <label for="local_vendor">Support Local Vendor</label>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-sm-4 col-12">
                                            <input type="checkbox" class="custom-checkbox" id="social_media">
                                            <label for="social_media">Social Media Content</label>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Guest Registry End -->





                <div class="row mt-5">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn wine-btn">Update</button>
                    </div>
                </div>
                    
                <!-- User Driving License Information End -->


            
            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')
@endsection