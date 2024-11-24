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
                  <li class="position-relative mb-3"><i class="fa-regular fa-circle-check"></i> Receive <b>$25</b> in bonus <b>Bottle Bucks</b> rewards just for registering.</li>
                  <li class="position-relative mb-3"><i class="fa-regular fa-circle-check"></i> Earn additional cash back reward dollars for submitting verifiable testimonials & reviews.</li>
                  <li class="position-relative mb-3"><i class="fa-regular fa-circle-check"></i> Save third-party booking fees and win periodic getaways to wine country.</li>
                  <li class="position-relative mb-3"><i class="fa-regular fa-circle-check"></i> Get access to exclusive guest lists, special events and functions.</li>
                  <li class="position-relative mb-3"><i class="fa-regular fa-circle-check"></i> Book a minimum of six (6) nights’ accommodations and get two (2) complimentary excursion activities. Only with participating vendors. Subject to availability.</li>
               </ul>
               <p class="fw-bold">Some benefits may not be valid in conjunction with other offers.</p>
         </div>
      </div>
   </div>
</section>
   @endsection