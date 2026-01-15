<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Hotel Is Live 🎉</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .content h2 {
            color: #28a745;
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 10px 0;
            font-size: 15px;
        }
        .info-box strong {
            color: #28a745;
            font-weight: 600;
        }
        .cta-button {
            display: inline-block;
            margin: 30px 0 20px;
            padding: 14px 32px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666666;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }
        .emoji {
            font-size: 24px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="email-container">

    <!-- Header -->
    <div class="header">
        <h1>Your Hotel Is Live 🚀</h1>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Hello {{ $tenant->woner_name }} <span class="emoji">🎉</span></h2>

        <p>
            Great news! Your tenant application has been <strong>approved</strong> and your hotel is now
            <strong>LIVE</strong> on our platform.
        </p>

        <div class="info-box">
            <p><strong>Hotel Name:</strong> {{ $tenant->hotel_name }}</p>
            <p>
                <strong>Dashboard URL:</strong><br>
                <a href="https://{{ $tenant->subdomain }}.yourdomain.com">
                    https://{{ $tenant->subdomain }}.yourdomain.com
                </a>
            </p>
            <p><strong>Plan:</strong> {{ optional($tenant->plan)->name }}</p>
            <p><strong>Status:</strong> Active</p>
        </div>

        <p>
            You can now log in to your dashboard and start managing:
        </p>

        <ul>
            <li>🏨 Rooms & Bookings</li>
            <li>👥 Guests & Check-ins</li>
            <li>💳 Payments & Invoices</li>
            <li>📊 Reports & Analytics</li>
        </ul>

        <center>
            <a href="https://{{ $tenant->subdomain }}.yourdomain.com" class="cta-button">
                Go to Dashboard
            </a>
        </center>

        <p>
            If you need any help during setup or onboarding, our support team is always ready to assist you.
        </p>

        <p style="margin-top: 30px;">
            Welcome aboard 🚀<br>
            <strong>Team {{ config('app.name') }}</strong>
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Need Support?</strong></p>
        <p>
            Email us at
            <a href="mailto:support@yourdomain.com" style="color:#28a745;">
                support@yourdomain.com
            </a>
        </p>
        <p style="margin-top: 20px; font-size: 12px; color: #999;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>

</div>
</body>
</html>
