<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    padding: 10px 0;
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
            <h1 style="font-size: 26px;font-weight: 500;color: #c0a144;margin-bottom: 0;">Contact Form Submission</h1>
        </div>
        <!-- /Email Header -->

        <!-- Email Body -->
        <div class="email-body">
            <p style="margin-bottom: 10px;"><b>Dear <span style="color: #c0a144;">Admin,</span></b></p>
            <p style="margin-top: 0;line-height: 24px;border-bottom: 1px solid #ececec;padding-bottom: 15px;margin-bottom: 20px;">You have received a new message from your website contact form. Here are the details:</p>
            <div class="fields-data">
               <p style="font-weight: bold;">First Name: <span style="font-weight:400">{{ $fname }}</span></p>
                <p style="font-weight: bold;">Last Name: <span style="font-weight:400">{{ $lname }}</span></p>
                <p style="font-weight: bold;">Email Address: <span style="font-weight:400">{{ $email }}</span></p>
                <p style="font-weight: bold;">Phone Number: <span style="font-weight:400">{{ $phone }}</span></p>
                <p style="font-weight: bold;">Subject: <span style="font-weight:400">{{ $subject }}</span></p>
                <p style="font-weight: bold;">Message: <span style="font-weight:400">{{ $message }}</span></p>
            </div>
        </div>
        <!-- /Email Body -->

        <!-- Email Footer -->
        <div class="email-footer" style="text-align: center;">
            <img src="https://winecountryweekends.ca/images/logo.png" style="width:150px;" alt="Logo">
            <div class="social-icons">
                <ul>
                    <li>
                        <a href="#">
                            <img src="https://devwine2.winecountryweekends.ca/images/email-icons/facebook.png" style="width:23px; height: 23px;" alt="Facebook">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="https://devwine2.winecountryweekends.ca/images/email-icons/instagram.png" style="width:21px; height: 21px;" alt="Instagram">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="https://devwine2.winecountryweekends.ca/images/email-icons/linkedin.png" style="width:23px; height: 23px;" alt="LinkedIn">
                        </a>
                    </li>
                    <li>
                        <a href="#"><img src="https://devwine2.winecountryweekends.ca/images/email-icons/tik-tok.png" style="width:20px; height: 20px;" alt="TikTok">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="https://devwine2.winecountryweekends.ca/images/email-icons/youtube.png" style="width:23px; height: 23px;" alt="YouTube">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="https://devwine2.winecountryweekends.ca/images/email-icons/twitter.png" style="width:23px; height: 23px;" alt="Twitter">
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