<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Guest Rewards Program</title>
</head>
<body>
    <div style="text-align: center;">
        <img src="https://devsite.winecountryweekends.ca/images/logo.png" alt="Wine Country Weekends" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';max-width:100%;border:none;height:auto;max-height:75px;width:auto" class="CToWUd" data-bit="iit">
    </div>
    <hr>
    <div>
        <p>Dear {{ $username }},</p>
        <p>Thank you for joining our Guest Rewards program.  We look forward to treating you to some of the best experiences the Niagara region has to offer.</p>

        <p>This may very well be the only email you receive from us because we do not employ email marketing tactics.  We prefer to engage you on whatever social media platform you use most.  It's less intrusive and we really enjoy creating the content.</p>

        <p>Just make sure you indicate in your personal profile which social media platforms you prefer to use and if you're not too shy, we may even invite you to play a role in one of our productions.</p>

        <p>If you would like to post a public testimonial or review about an experience at any of our listed vendors, you will need to upload a headshot to accompany your post.  We are a community of fun loving travelers that like to see a face attached to the comments posted.</p>
        <p>Please follow the link below to login to your personal account dashboard and update/manage your account accordingly.</p>
        <p><a href="{{ $loginLink }}">Click here to login</a></p>
        <p>Cheers!<br>WCW Marketing Team</p>
    </div>
    <div class="email-footer" style="text-align: center;">
    <img src="https://winecountryweekends.ca/images/logo.png" style="width:150px;" alt="Logo">
    <p>&copy; 2024 Wine Country Weekends. All rights reserved.</p>
    </div>
</body>
</html>