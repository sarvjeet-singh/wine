@extends('emails.layouts.inquiry')

@section('title', 'Winery Inquiry')

@section('content')
    <div class="info-outer" style="margin-top: 30px;">
        <div class="section" style="background-color: #f9f9f9;padding: 20px;border-radius: 15px;">
            <div class="main-title">Winery Inquiries</div>
            <div style="margin-bottom: 30px;">
                <div class="section-title" style="color: #c0a144;">Guest Information</div>
                <div>
                    <div style="margin-bottom: 10px;"><strong>User/Travelers Full Name:</strong> <span>{{$inquiryData['user']->firstname ?? ''}} {{$inquiryData['user']->lastname ?? ''}}</span>
                    </div>
                    <div style="margin-bottom: 10px;"><strong>eMail:</strong> <span>{{$inquiryData['user']->email ?? ''}}</span></div>
                    <div><strong>Phone: (if available):</strong> <span>+1 {{$inquiryData['user']->contact_number ?? ''}}</span></div>
                </div>
            </div>
            <div style="margin-bottom: 30px;">
                <div class="section-title" style="color: #c0a144;">Vendor Information</div>
                <div>
                    <div style="margin-bottom: 10px;"><strong>Category: </strong> <span>{{ucfirst($inquiryData['vendor']->vendor_type) ?? ''}}</span></div>
                    <div style="margin-bottom: 10px;"><strong>Sub-Category: </strong> <span>{{$inquiryData['vendor']->sub_category->name ?? ''}}</span></div>
                    {{-- <div style="margin-bottom: 10px;"><strong>Establishment/Facility: </strong> <span>Restaurant</span>
                    </div> --}}
                    <div style="margin-bottom: 10px;"><strong>Business/Vendor Name: </strong> <span>{{$inquiryData['vendor']->vendor_name ?? ''}}</span></div>
                    <div style="margin-bottom: 10px;"><strong>Street Address: </strong> <span>{{$inquiryData['vendor']->street_address ?? ''}}</span>
                    </div>
                    <div style="margin-bottom: 10px;"><strong>City/Town: </strong> <span>{{$inquiryData['vendor']->city ?? ''}}</span></div>
                    <div style="margin-bottom: 10px;"><strong>Business/Vendor Phone: </strong> <span>+1 {{$inquiryData['vendor']->vendor_phone ?? ''}}</span>
                    </div>
                </div>
            </div>
            <div class="section">
                <div class="section-title" style="color: #c0a144;">Inquiry Details</div>
                <table class="details-table">
                    <tr>
                        <th width="50%">What is your tentative arrival/check-in date?</th>
                        <td width="50%">{{$inquiryData['inquiry']['check_in_date'] ?? ''}}</td>
                    </tr>
                    <tr>
                        <th width="50%">What is your tentative departure/check-out date?</th>
                        <td width="50%">{{$inquiryData['inquiry']['check_out_date'] ?? ''}}</td>
                    </tr>
                    <tr>
                        <th width="50%">What is the nature of your visit?</th>
                        <td width="50%">{{$inquiryData['inquiry']['visit_nature'] ?? ''}}</td>
                    </tr>
                    <tr>
                        <th width="50%">How many guests in your travel party?</th>
                        <td width="50%">{{$inquiryData['inquiry']['number_of_guests'] ?? ''}}</td>
                    </tr>
                    <tr>
                        <th width="50%">In what sub-region would you prefer to be situated?</th>
                        <td width="50%">{{$inquiryData['inquiry']['sub_region'] ?? ''}}</td>
                    </tr>
                    <tr>
                        <th width="50%">What type of winery do you prefer?</th>
                        <td width="50%">{{$inquiryData['inquiry']['winery_types'] ?? ''}}</td>
                    </tr>
                    <tr>
                        <th width="50%">Do you prefer tastings or an immersive experience?</th>
                        <td width="50%">{{$inquiryData['inquiry']['experience_preference'] ?? ''}}</td>
                    </tr>
                    <tr>
                        <th width="50%">Additional Comments</th>
                        <td width="50%">{{$inquiryData['inquiry']['additional_comments'] ?? ''}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
