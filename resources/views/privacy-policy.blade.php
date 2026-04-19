<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - Skillzy</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #F0F0F0;
            color: #121212;
        }

        .navbar {
            background-color: white;
            border-bottom: 4px solid #121212;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 900;
            text-decoration: none;
            color: #121212;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 1rem;
            border-bottom: 4px solid #D02020;
            padding-bottom: 1rem;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #1040C0;
        }

        p {
            line-height: 1.8;
            margin-bottom: 1rem;
            color: #333;
        }

        ul {
            margin-left: 2rem;
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        li {
            margin-bottom: 0.5rem;
            color: #333;
        }

        .footer {
            background-color: #f5f5f5;
            border-top: 4px solid #121212;
            padding: 2rem 1.5rem;
            text-align: center;
            margin-top: 3rem;
        }

        .back-link {
            display: inline-block;
            color: #1040C0;
            text-decoration: none;
            font-weight: 600;
            margin-top: 2rem;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #D02020;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ route('landing') }}" class="logo">Skillzy</a>
        <a href="{{ route('landing') }}" style="text-decoration: none; color: #1040C0; font-weight: 600;">← Back to Home</a>
    </div>

    <div class="container">
        <h1>Privacy Policy</h1>
        <p>Last Updated: April 19, 2026</p>

        <h2>1. Introduction</h2>
        <p>Skillzy ("we," "us," "our," or "Company") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and platform.</p>

        <h2>2. Information We Collect</h2>
        <p>We may collect information about you in a variety of ways. The information we may collect on the Platform includes:</p>
        <ul>
            <li><strong>Personal Data:</strong> Name, email address, phone number, address, username, password, and profile information</li>
            <li><strong>Financial Data:</strong> Skillzy Coin balance, transaction history, and payment information</li>
            <li><strong>Usage Data:</strong> Pages visited, time spent, browser type, IP address, and referring URL</li>
            <li><strong>Communication Data:</strong> Messages, reviews, and feedback you provide</li>
            <li><strong>Location Data:</strong> General location information (if permitted)</li>
        </ul>

        <h2>3. Use of Your Information</h2>
        <p>We use the information we collect in various ways, including to:</p>
        <ul>
            <li>Provide, maintain, and improve our services</li>
            <li>Process your transactions and send related information</li>
            <li>Send promotional communications (with your consent)</li>
            <li>Respond to your inquiries and provide customer support</li>
            <li>Monitor and analyze platform usage and trends</li>
            <li>Detect and prevent fraudulent transactions</li>
            <li>Comply with legal obligations</li>
        </ul>

        <h2>4. Disclosure of Your Information</h2>
        <p>We may share your information in the following situations:</p>
        <ul>
            <li><strong>With Service Providers:</strong> Third parties who assist us in operating our website and conducting our business</li>
            <li><strong>For Legal Requirements:</strong> When required by law or to protect our legal rights</li>
            <li><strong>Business Transfers:</strong> If we merge, acquire, or sell assets, your information may be transferred</li>
            <li><strong>With Your Consent:</strong> When you explicitly agree to share information</li>
        </ul>

        <h2>5. Security of Your Information</h2>
        <p>We use administrative, technical, and physical security measures to protect your personal information. However, no method of transmission over the Internet or electronic storage is 100% secure. We cannot guarantee absolute security.</p>

        <h2>6. Retention of Your Information</h2>
        <p>We will retain your personal data for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required or permitted by law.</p>

        <h2>7. Your Privacy Rights</h2>
        <p>Depending on your location, you may have the following rights:</p>
        <ul>
            <li>The right to access your personal data</li>
            <li>The right to correct inaccurate data</li>
            <li>The right to request deletion of your data</li>
            <li>The right to opt-out of promotional communications</li>
        </ul>

        <h2>8. Contact Us</h2>
        <p>If you have questions about this Privacy Policy, please contact us at:</p>
        <p>
            Email: privacy@skillzy.com<br>
            Address: Your Company Address<br>
            Phone: Your Contact Number
        </p>

        <a href="{{ route('landing') }}" class="back-link">← Back to Home</a>
    </div>

    <div class="footer">
        <p>&copy; 2026 Skillzy. All rights reserved.</p>
    </div>
</body>
</html>
