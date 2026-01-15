<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #667eea;
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 10px 0;
            font-size: 15px;
        }
        .info-box strong {
            color: #667eea;
            font-weight: 600;
        }
        .subdomain-link {
            display: inline-block;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .subdomain-link:hover {
            text-decoration: underline;
        }
        .cta-button {
            display: inline-block;
            margin: 30px 0 20px;
            padding: 14px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666666;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 8px 0;
        }
        .emoji {
            font-size: 24px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to Your Hotel Management Platform</h1>
        </div>
        
        <div class="content">
            <h2>Welcome {{ $tenant->owner_name }} <span class="emoji">👋</span></h2>
            
            <p>We're thrilled to have you join our platform! Your hotel has been successfully registered and is ready to go.</p>
            
            <div class="info-box">
                <p><strong>Hotel Name:</strong> {{ $tenant->hotel_name }}</p>
                <p><strong>Subdomain:</strong> <a href="https://{{ $tenant->preferred_subdomain }}.yourdomain.com" class="subdomain-link">{{ $tenant->preferred_subdomain }}.yourdomain.com</a></p>
            </div>
            
            <p>Your personalized dashboard is now live and accessible through your unique subdomain. You can start managing your hotel operations, bookings, and guest experiences right away.</p>
            
            <center>
                <a href="https://{{ $tenant->preferred_subdomain }}.yourdomain.com" class="cta-button">
                    Access Your Dashboard
                </a>
            </center>
            
            <p>If you have any questions or need assistance getting started, our support team is here to help.</p>
            
            <p style="margin-top: 30px;">
                Best regards,<br>
                <strong>The Team</strong>
            </p>
        </div>
        
        <div class="footer">
            <p><strong>Need Help?</strong></p>
            <p>Contact us at <a href="mailto:support@yourdomain.com" style="color: #667eea;">support@yourdomain.com</a></p>
            <p style="margin-top: 20px; color: #999999; font-size: 12px;">
                © {{ date('Y') }} Your Company Name. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>