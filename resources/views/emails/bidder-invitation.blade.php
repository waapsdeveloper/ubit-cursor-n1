<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidder Invitation - Sahil e Firdaus Auctions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #6449E7 0%, #8B5CF6 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            background: #6449E7;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
        .highlight {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Welcome to Sahil e Firdaus Auctions!</h1>
        <p>Your bidder application has been approved</p>
    </div>

    <div class="content">
        <h2>Dear {{ $user->name }},</h2>
        
        <p>Great news! Your bidder application has been reviewed and approved. We're excited to welcome you to our exclusive auction community.</p>

        <div class="highlight">
            <strong>Your Application Details:</strong><br>
            • Application ID: #{{ $application->id }}<br>
            • Deposit Amount: PKR {{ number_format($application->deposit_amount, 0) }}<br>
            • Status: Payment Verified ✅
        </div>

        <h3>Next Steps:</h3>
        <ol>
            <li><strong>Activate Your Account:</strong> Click the button below to activate your bidder account</li>
            <li><strong>Start Bidding:</strong> Once activated, you can participate in all our auctions</li>
            <li><strong>Explore Properties:</strong> Browse through our premium property listings</li>
        </ol>

        <div style="text-align: center;">
            <a href="{{ url('/register?invite=' . $invite->code) }}" class="button">
                🚀 Activate My Bidder Account
            </a>
        </div>

        <p><strong>Important Notes:</strong></p>
        <ul>
            <li>This invitation link is unique to your account and should not be shared</li>
            <li>Your deposit of PKR {{ number_format($application->deposit_amount, 0) }} will be held as security for your bidding activities</li>
            <li>You can withdraw your deposit at any time by contacting our support team</li>
            <li>As a verified bidder, you'll have access to exclusive properties and priority support</li>
        </ul>

        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

        <p>Best regards,<br>
        <strong>The Sahil e Firdaus Auctions Team</strong></p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Sahil e Firdaus Auctions. All rights reserved.</p>
        <p>This email was sent to {{ $invite->email }}. If you didn't apply for a bidder account, please ignore this email.</p>
    </div>
</body>
</html> 