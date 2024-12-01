<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777777;
            margin-top: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Our Service!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->email }},</p>
            <p>Thank you for signing up for our service. We are excited to have you on board!</p>
            <p>Please click the link below to verify your email address:</p>
            <p><a href="http://localhost:8000/check_email/{{ $user->remember_token }}">Verify Email Address</a></p>
            <p>If you did not create an account, no further action is required.</p>
            <p>Best regards,<br>The Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
