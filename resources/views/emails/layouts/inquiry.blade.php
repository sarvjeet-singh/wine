<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Inquiry Received</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap');

        body {
            font-family: 'Inter Tight', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .email-container {
            max-width: 680px;
            margin: 20px auto;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e6e6e6;
            background-color: #fff;
        }

        .header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #e6e6e6;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .content {
            padding: 25px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .main-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table th,
        .details-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #f3f3f3;
            font-size: 15px;
        }

        .details-table th {
            background-color: #fff;
            color: #333;
            font-weight: bold;
            vertical-align: top;
        }

        .details-table td {
            background-color: #ffffff;
        }

        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }

        .social-icons ul {
            list-style: none;
            padding: 0;
            margin-top: 0;
        }

        .social-icons ul li {
            display: inline-block;
            padding: 0 2px;
        }
    </style>
</head>

<body>
    @include('emails.layouts.inquiry-header')
    @yield('content')
    @include('emails.layouts.inquiry-footer')
</body>

</html>
