<!DOCTYPE html>
<html>
<head>
    <title>New Vendor Account</title>
</head>
<body>
    <h1>Welcome to Our Platform</h1>
    <p>Dear {{ $user->firstname }},</p>
    <p>You have been assigned administrative access to the vendor side of the WCW marketplace platform. You are now able to use the following credentials to access and manage the Business/Vendor Name account and any other vendor account you may be associated with. </p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>You may update your password to something more suitable after logging in for the first time. </p>
    <p>Thank you for your participation and welcome to the marketplace section of our platform!</p>
    <p>Sincerely,<p>
    <p><strong>System Admin</strong></p>
    <div class="email-footer" style="text-align: center;">
    <img src="winecountryweekends.ca/images/logo.png" style="width:150px;" alt="Logo">
    <p>&copy; 2024 Wine Country Weekends. All rights reserved.</p>
    </div>
</body>
</html>
