<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Template</title>    
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap');
body {
    font-family: 'Inter Tight', Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}
.email-container {
    max-width: 600px;
    margin: 20px auto;
    background-color: #ffffff;
    border: 1px solid #dddddd42;
    border-radius: 15px;
}
.email-header {
    text-align: center;
    padding: 20px 0 10px;
    border-radius: 10px 10px 0 0;
}
.email-body {
    padding: 0 30px 30px 30px;
}
.email-body .credentials {
    background-color: #cde4e6;
    padding: 10px 15px;
    border: 1px dashed #118c97;
    margin: 20px 0;
}
.email-body .credentials p {
    margin: 0;
    font-weight: bold;
    font-size: 14px;
}
.email-body p {
    font-size: 15px;
    line-height: 1.5;
    margin: 0 0 15px 0;
}
.email-footer {        
    font-size: 13px;
}
.social-icons ul {
    list-style: none;
    padding: 0;
}
.social-icons ul li {
    display: inline-block;
    padding: 0 2px;
}
.button {
    display: inline-block;
    background-color: #118c97;
    color: #ffffff;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 14px;
}
</style>
</head>
<body>
  <div class="email-container">
    @include('emails.vendor.vendorLayouts.header')
    @yield('content')
    @include('emails.vendor.vendorLayouts.footer')
  </div>
</body>
</html>