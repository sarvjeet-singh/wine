@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Rewards')

@section('content')   
<section class="guest-reward-sec border-top py-sm-5 py-4 mb-sm-5 mb-4">
   <div class="container">
      <div class="inner-sec position-relative py-5">
         <div class="sec-head">
            <h2 class="fs-1 fw-bold theme-color text-center mb-sm-5 mb-4">Current Benefits:</h2>
         </div>
         <div class="benefits">           
            <ul class="list-unstyled">
                  <li class="position-relative mb-3"><i class="fa-regular fa-circle-check"></i> Get $25 in bonus Bottle Bucks rewards just for joining our Guest Rewards program.</li>
                  <li class="position-relative mb-3"><i class="fa-regular fa-circle-check"></i> Save third-party booking fees, win prizes and earn more rewards.</li>
                  <li class="position-relative mb-3"><i class="fa-regular fa-circle-check"></i> Get access to exclusive guest lists, special events and functions.</li>
                  <li class="position-relative mb-3"><i class="fa-regular fa-circle-check"></i> Book a minimum of six (6) nights’ accommodations and get two (2) complimentary excursion activities.  Only with participating vendors.  Subject to availability.</li>
               </ul>
         </div>
      </div>
   </div>
</section>
   @endsection