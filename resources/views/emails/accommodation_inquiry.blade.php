<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation Inquiry Template</title>    
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap');
body {
    font-family: 'Inter Tight', Arial, sans-serif;
    margin: 0;
    padding: 0;
}
.email-container {
    max-width: 600px;
    margin: 20px auto;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    border-radius: 20px;
}
.email-header {    
    text-align: center;
    padding: 10px 40px;
    border-radius: 10px 10px 0 0;
}
.email-body {
    padding: 0 40px 10px 40px;
}
.email-footer {        
    font-size: 13px;
}
.table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    text-align: left;
}
.table th, .table td {
    padding: 10px;
    border: 1px solid #dddddd;
}
.table td {
    background-color: #fff;
}
.table th {
    background-color: #fff;
    width: 40%;
    font-size: 15px;
    font-weight: 600;
}
.social-icons ul {
    list-style: none;
    padding: 0;
}
.social-icons ul li {
    display: inline-block;
    padding: 0 6px;
}
</style>
</head>
<body>
    <div class="email-container">
        <!-- Email Header -->
        <div class="email-header">
            <h1 style="font-size: 26px;font-weight: 500;color: #c0a144;margin-bottom: 0;">Accommodation Inquiry</h1>
            <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        </div>
        <!-- /Email Header -->

        <!-- Email Body -->
        <div class="email-body">
            <table style="width: 100%; margin-bottom: 20px; border-bottom: 1px solid #ececec;">
                <tr>
                    <td>
                        <div class="guest-details" style="margin: 10px 0;">
                            <h6 style="font-size: 18px;font-weight: bold; color: #c0a144;margin:0 0 10px 0;">Guest Details </h6>
                            <p style="font-weight: bold;margin: 4px 0;">First Name: <span style="font-weight:400">{{ $user->firstname }}</span></p>
                            <p style="font-weight: bold;margin: 4px 0;">Last Name: <span style="font-weight:400">{{ $user->lastname }}</span></p>
                            <p style="font-weight: bold;margin: 4px 0;">Email Address: <span style="font-weight:400">{{ $user->email }}</span></p>
                            <p style="font-weight: bold;margin: 4px 0;">Phone Number: <span style="font-weight:400">{{ $user->contact_number }}</span></p>
                        </div>    
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="guest-details" style="margin: 10px 0 20px 0;">
                            <h6 style="font-size: 18px;font-weight: bold; color: #c0a144;margin:0 0 10px 0;">Vendor Details:</h6>
                            <p style="font-weight: bold;margin: 4px 0;">Vendor Name: <span style="font-weight:400">{{ $vendor->vendor_name }}</span></p>
                            <p style="font-weight: bold;margin: 4px 0;">Sub Region: <span style="font-weight:400">{{ $vendor->sub_region }}</span></p>
                            <p style="font-weight: bold;margin: 4px 0;">Street Address: <span style="font-weight:400">{{ $vendor->street_address }}</span></p>
                            <p style="font-weight: bold;margin: 4px 0;">City: <span style="font-weight:400">{{ $vendor->city }}</span></p>
                            <p style="font-weight: bold;margin: 4px 0;">Business/Phone Number: <span style="font-weight:400">{{ $vendor->vendor_phone }}</span></p>
                        </div>    
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td><h6 style="font-size: 18px;font-weight: bold; color: #c0a144;margin:0 0 10px 0;">Below are your details</h6></td>
                </tr>
                <tr>
                    <td>
                        <p style="font-weight: bold;margin: 4px 0;">What is your tentative travel/check-in date?</p>
                        <p style="font-weight: 400;margin: 4px 0;">{{ $validated['check_in'] }}</p>
                    </td>                    
                </tr>
                <tr>                    
                    <td>
                        <p style="font-weight: bold;margin: 4px 0;">What is your tentative travel/check-out date?</p>
                        <p style="font-weight: 400;margin: 4px 0;">{{ $validated['check_out'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-weight: bold;margin: 4px 0;">What is the nature of your visit?</p>
                        <p style="font-weight: 400;margin: 4px 0;">{{ $validated['visit_nature'] }}</p>
                    </td>
                </tr>
                <tr>            
                    <td>
                        <p style="font-weight: bold;margin: 4px 0;">How many guests are in your travel party?</p>
                        <p style="font-weight: 400;margin: 4px 0;">{{ $validated['guest_no'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-weight: bold;margin: 4px 0;">What is your preferred accommodation type?</p>
                        <p style="font-weight: 400;margin: 4px 0;">{{ $validated['vendor_sub_category'] }}</p>
                    </td>                    
                </tr>
                <tr>                
                    <td>
                        <p style="font-weight: bold;margin: 4px 0;">What sub-region would you prefer to be located?</p>
                        <p style="font-weight: 400;margin: 4px 0;">{{ $validated['sub_region'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-weight: bold;margin: 4px 0;">Please indicate the number of rooms required.</p>
                        <p style="font-weight: 400;margin: 4px 0;"> {{ $validated['rooms_required'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-weight: bold;margin: 4px 0;">Additional Comments:</p>
                        <p style="font-weight: 400;margin: 4px 0;">{{ $validated['additional_comments_inquiry'] }}</p>
                    </td>
                </tr>
            </table>
        </div>
        <!-- /Email Body -->

        <!-- Email Footer -->
        <div class="email-footer" style="text-align: center;">
            <img src="https://winecountryweekends.ca/images/logo.png" style="width:150px;" alt="Logo">
            <div class="social-icons">
            <ul>
                    <li>
                        <a href="#">
                            <img src="{{ asset('images/FrontEnd/image 10.png') }}" style="width:23px; height: 23px;" alt="Facebook">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('images/FrontEnd/image 13.png') }}" style="width:21px; height: 21px;" alt="Instagram">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('images/FrontEnd/image 14.png') }}" style="width:23px; height: 23px;" alt="LinkedIn">
                        </a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ asset('images/FrontEnd/image 11.png') }}" style="width:20px; height: 20px;" alt="TikTok">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('images/FrontEnd/image 12.png') }}" style="width:23px; height: 23px;" alt="YouTube">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('images/FrontEnd/twitter-x.png') }}" style="width:23px; height: 23px;" alt="Twitter">
                        </a>
                    </li>
                </ul>
            </div>
            <p>&copy; 2024 Wine Country Weekends. All rights reserved.</p>
        </div>
        <!-- /Email Footer -->
    </div>
</body>
</html>