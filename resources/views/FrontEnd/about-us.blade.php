@extends('FrontEnd.layouts.mainapp')

@section('content')
    <section class="two-col-sec about-sec">
        <div class="container">
            <div class="sec-head text-center mb-sm-5 mb-4">
                <h2 class="fw-bold theme-color text-uppercase">About Us</h2>
            </div>
            <div class="row g-sm-5 g-4">
                <div class="col-xl-6">
                    <div class="sec-img">
                        <img src="{{asset('images/FrontEnd/img4.jpeg') }}" class="img-fluid">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="sec-content">
                        <p>Wine Country Weekends (WCW) is a marketing cooperative comprised of local vendor partners working together to promote and deliver the best experiences wine country has to offer. Our mandate is to popularize Niagara’s wine country and all it has to offer by executing a strategic marketing plan that highlights vendor partners and promotes the region as a world class wine destination.</p>
                        <p>To our collective wine country guests we are a team of experience curators that provide travel services to help ensure a remarkable experience with each visit. The WCW online platform is designed to educate users about their various travel options and what participating vendors have to offer.</p>
                        <p>Content and information is organized using profiles and offer a brief overview of the subject vendor. Not all listed vendors are active partners. Many of the listed vendors simply offer a product or service we deemed worthy of mention. Provided content and information can be used to (A); educate users on available travel options and (B); help plan itineraries in advance of travel.</p>
                        <p>The WCW team is dedicated to actively working behind the scenes with vendor partners to source and develop excursion activities that will add new and distinct layers to the guest experience. Every fact of the guest experience can and will be tailored for maximum enjoyment, lead by local artisans and curated by the WCW team.</p>
                        <p>Join our <a @guest href="{{route('register')}}" @else href="{{route('guest-rewards')}}" @endguest class="text-decoration-none theme-color">Guest Rewards</a> program to maximize your benefits.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



