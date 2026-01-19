<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subdomain Not Found - hotlr.com</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            padding: 50px 40px;
            text-align: center;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .icon svg {
            width: 60px;
            height: 60px;
            fill: white;
        }

        h1 {
            font-size: 28px;
            color: #2d3748;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .subdomain {
            color: #667eea;
            font-weight: 800;
            font-family: 'Courier New', monospace;
            background: #f7fafc;
            padding: 8px 15px;
            border-radius: 8px;
            display: inline-block;
            margin: 10px 0;
        }

        p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .reasons {
            background: #f7fafc;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
            border-radius: 8px;
        }

        .reasons h3 {
            color: #2d3748;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .reasons ul {
            list-style: none;
            padding-left: 0;
        }

        .reasons li {
            padding: 8px 0;
            color: #4a5568;
            position: relative;
            padding-left: 25px;
        }

        .reasons li:before {
            content: "→";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }

        .help-text {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            color: #718096;
        }

        .help-text a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .help-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 40px 25px;
                border-radius: 15px;
            }

            .icon {
                width: 100px;
                height: 100px;
                margin-bottom: 25px;
            }

            .icon svg {
                width: 50px;
                height: 50px;
            }

            h1 {
                font-size: 24px;
                margin-bottom: 12px;
            }

            p {
                font-size: 15px;
            }

            .subdomain {
                font-size: 14px;
                padding: 6px 12px;
                word-break: break-all;
            }

            .reasons {
                padding: 15px;
                margin: 25px 0;
            }

            .reasons h3 {
                font-size: 16px;
                margin-bottom: 12px;
            }

            .reasons li {
                font-size: 14px;
                padding: 6px 0;
            }

            .buttons {
                flex-direction: column;
                gap: 12px;
                margin-top: 25px;
            }

            .btn {
                width: 100%;
                justify-content: center;
                padding: 12px 25px;
                font-size: 14px;
            }

            .help-text {
                margin-top: 25px;
                padding-top: 25px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 30px 20px;
            }

            .icon {
                width: 80px;
                height: 80px;
                margin-bottom: 20px;
            }

            .icon svg {
                width: 40px;
                height: 40px;
            }

            h1 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }

            .subdomain {
                font-size: 12px;
                padding: 5px 10px;
            }

            .reasons {
                padding: 12px;
                margin: 20px 0;
            }

            .reasons h3 {
                font-size: 15px;
            }

            .reasons li {
                font-size: 13px;
                padding-left: 20px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 13px;
            }
        }

        @media (max-width: 360px) {
            .container {
                padding: 25px 15px;
            }

            h1 {
                font-size: 18px;
            }

            .subdomain {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
        </div>

        <h1>Subdomain Not Found</h1>
        
        <p>We couldn't find the subdomain:</p>
        <div class="subdomain" id="subdomain-name">abc.hotlr.com</div>

        <div class="reasons">
            <h3>This could happen because:</h3>
            <ul>
                <li>The subdomain doesn't exist or has been removed</li>
                <li>There might be a typo in the URL</li>
                <li>The service or account may have been deactivated</li>
                <li>The subdomain hasn't been set up yet</li>
            </ul>
        </div>

        <p>What would you like to do?</p>

        <div class="buttons">
            <a href="https://hotlr.com" class="btn btn-primary">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                Go to Homepage
            </a>
            <button onclick="window.history.back()" class="btn btn-secondary">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
                Go Back
            </button>
        </div>

        <div class="help-text">
            Need help? <a href="https://hotlr.com/contact">Contact Support</a> or 
            <a href="https://hotlr.com/faq">Visit FAQ</a>
        </div>
    </div>

    <script>
        // Automatically extract and display the subdomain from URL
        window.addEventListener('DOMContentLoaded', function() {
            const hostname = window.location.hostname;
            const subdomainElement = document.getElementById('subdomain-name');
            
            if (hostname && subdomainElement) {
                subdomainElement.textContent = hostname;
            }
        });
    </script>
</body>
</html>