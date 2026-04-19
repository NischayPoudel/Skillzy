<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms & Conditions - Skillzy</title>
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
        <h1>Terms & Conditions</h1>
        <p>Last Updated: April 19, 2026</p>

        <h2>1. Acceptance of Terms</h2>
        <p>By accessing and using Skillzy ("Platform"), you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>

        <h2>2. Use License</h2>
        <p>Permission is granted to temporarily download one copy of the materials (information or software) on Skillzy for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
        <ul>
            <li>Modifying or copying the materials</li>
            <li>Using the materials for any commercial purpose or for any public display</li>
            <li>Attempting to decompile or reverse engineer any software contained on Skillzy</li>
            <li>Removing any copyright or other proprietary notations from the materials</li>
            <li>Transferring the materials to another person or "mirroring" the materials on any other server</li>
        </ul>

        <h2>3. Disclaimer</h2>
        <p>The materials on Skillzy's Platform are provided on an 'as is' basis. Skillzy makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>

        <h2>4. Limitations</h2>
        <p>In no event shall Skillzy or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on Skillzy's Platform.</p>

        <h2>5. Accuracy of Materials</h2>
        <p>The materials appearing on Skillzy could include technical, typographical, or photographic errors. Skillzy does not warrant that any of the materials on its Platform are accurate, complete, or current. Skillzy may make changes to the materials contained on its Platform at any time without notice.</p>

        <h2>6. Materials on Skillzy</h2>
        <p>Skillzy has not reviewed all of the sites linked to its Platform and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by Skillzy of the site. Use of any such linked website is at the user's own risk.</p>

        <h2>7. Modifications</h2>
        <p>Skillzy may revise these terms of service for its Platform at any time without notice. By using this Platform, you are agreeing to be bound by the then current version of these terms of service.</p>

        <h2>8. Governing Law</h2>
        <p>These terms and conditions are governed by and construed in accordance with the laws of the jurisdiction in which Skillzy operates, and you irrevocably submit to the exclusive jurisdiction of the courts in that location.</p>

        <h2>9. Coin System</h2>
        <p>Skillzy Coins are virtual currency used on our Platform for peer-to-peer skill exchange. Users acknowledge that:</p>
        <ul>
            <li>Coins have no real-world monetary value</li>
            <li>Coins cannot be exchanged for fiat currency or real money</li>
            <li>Coin balance is non-transferable and belongs to the Platform</li>
            <li>Skillzy reserves the right to modify the coin system at any time</li>
        </ul>

        <h2>10. User Conduct</h2>
        <p>You agree to use the Platform only for lawful purposes and in a way that does not infringe upon the rights of others or restrict their use and enjoyment of the Platform. Prohibited behavior includes:</p>
        <ul>
            <li>Harassing or causing distress or inconvenience to any person</li>
            <li>Obscene or offensive language or graphics</li>
            <li>Disruption of the normal flow of dialogue within Skillzy's Platform</li>
            <li>Fraudulent or deceptive activity</li>
        </ul>

        <h2>11. Contact Us</h2>
        <p>If you have questions about these Terms & Conditions, please contact us at:</p>
        <p>
            Email: support@skillzy.com<br>
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
