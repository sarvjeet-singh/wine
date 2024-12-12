@extends('emails.layouts.inquiry')

@section('title', 'Winery Inquiry')

@section('content')
    <div class="content">
        <div class="section">
            <p style="margin: 0;">Dear Admin,</p>
            <p style="margin-top: 10px;">A new winery inquiry has been submitted. Below are the details:</p>
        </div>
        <!-- Winery Inquiries -->
        <div class="info-outer">
            <div class="section">
                <div class="main-title">Winery Inquiries</div>
                <div class="section-title">Guest Information</div>
                <table class="details-table">
                    <tr>
                        <th width="40%">User/Travelers Full Name</th>
                        <td width="60%">{{$inquiryData['user']->firstname}} {{$inquiryData['user']->lastname}}</td>
                    </tr>
                    <tr>
                        <th width="40%">eMail</th>
                        <td width="60%">{{$inquiryData['user']->email}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Phone: (if available)</th>
                        <td width="60%">+1 {{$inquiryData['user']->phone}}</td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <div class="section-title">Vendor Information</div>
                <table class="details-table">
                    <tr>
                        <th width="40%">Category</th>
                        <td width="60%">Accommodation</td>
                    </tr>
                    <tr>
                        <th width="40%">Sub-Category</th>
                        <td width="60%">{{$inquiryData['vendor']->sub_category->name}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Business/Vendor Name</th>
                        <td width="60%">{{$inquiryData['vendor']->vendor_name}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Street Address</th>
                        <td width="60%">{{$inquiryData['vendor']->street_address}}</td>
                    </tr>
                    <tr>
                        <th width="40%">City / Town</th>
                        <td width="60%">{{$inquiryData['vendor']->city}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Business / Vendor Phone:</th>
                        <td width="60%">+1 {{$inquiryData['vendor']->vendor_phone}}</td>
                    </tr>
                </table>
            </div>

            <div class="section" style="margin-bottom: 0;">
                <div class="section-title">Inquiry Details</div>
                <table class="details-table">
                    <tr>
                        <th width="40%">Arrival/Check-in Date</th>
                        <td width="60%">{{$inquiryData['inquiry']['check_in_date']}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Departure/Check-out Date</th>
                        <td width="60%">{{$inquiryData['inquiry']['check_out_date']}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Nature of Visit</th>
                        <td width="60%">{{$inquiryData['inquiry']['visit_nature']}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Number of Guests</th>
                        <td width="60%">{{$inquiryData['inquiry']['number_of_guests']}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Prefer Tastings or an Immersive Experience</th>
                        <td width="60%">{{$inquiryData['inquiry']['experience_preference']}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Sub region prefer</th>
                        <td width="60%">{{$inquiryData['inquiry']['sub_region']}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Preferred Winery</th>
                        <td width="60%">{{$inquiryData['inquiry']['winery_types']}}</td>
                    </tr>
                    <tr>
                        <th width="40%">Additional Comments</th>
                        <td width="60%">{{$inquiryData['inquiry']['additional_comments']}}.</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
