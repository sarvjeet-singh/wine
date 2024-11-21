@extends('FrontEnd.layouts.mainapp')

@section('content')
    <section class="two-col-sec contact-sec">
        <div class="container">
            <div class="sec-head text-center mb-sm-5 mb-4">
                <h2 class="fw-bold theme-color text-uppercase">Contact Us</h2>
                <h6 class="fw-bold">Collaborators Welcomed</h6>
            </div>
            <div class="row align-items-center g-sm-5 g-4">
                <div class="col-lg-6">				
                    <div class="sec-content">
                        <p>At Wine Country Weekends we don’t typically hire, we collaborate. We believe that the whole is greater than the sum of its parts and we are always on the lookout for new talent. Join our team of free ranging entrepreneur types.</p>
                        <p>Mind blowing stuff? Maybe but if you can wrap your head around the concept, hit us up. Pitch us on how what you do, will make what we do, better. If we smell what you’re cooking, we may offer you a seat at our table.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="sec-form mx-lg-4">
                        <div class="sec-head">
                            <h3 class="fs-4 fw-bold text-uppercase theme-color mb-4">Contact Form</h3>
                        </div>
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <form class="row g-3" action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="First Name" name="fname" id="fname" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Last Name" name="lname" id="lname" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="Email Address" name="email" id="email" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Phone Number" name="phone" id="phone" required>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Subject" name="subject" id="subject" required>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" placeholder="Message" name="message" id="floatingTextarea" required></textarea>
                            </div>
                            <div class="col-12">
                                <div class="g-recaptcha" data-sitekey="6Le9wQYqAAAAAIA4JtqRXcGcTYqPgOu2sGyQoSgL"></div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection