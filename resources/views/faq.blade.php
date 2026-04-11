<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FAQ - Skillzy</title>
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
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-logo {
            font-size: 1.5rem;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #121212;
        }

        .navbar-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .navbar-links a {
            text-decoration: none;
            color: #121212;
            font-weight: 600;
            transition: color 0.3s ease;
            font-size: 0.95rem;
        }

        .navbar-links a:hover {
            color: #D02020;
        }

        .container {
            max-width: 900px;
            margin: 4rem auto;
            padding: 0 1.5rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 1rem;
            text-align: center;
        }

        .page-subtitle {
            text-align: center;
            font-size: 1rem;
            color: #666;
            margin-bottom: 3rem;
        }

        .faq-item {
            background-color: white;
            padding: 2rem;
            border: 4px solid #121212;
            margin-bottom: 1.5rem;
            box-shadow: 4px 4px 0px 0px rgba(18, 18, 18, 0.05);
        }

        .faq-question {
            font-size: 1.1rem;
            font-weight: 700;
            color: #121212;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: color 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-question:hover {
            color: #D02020;
        }

        .faq-toggle {
            font-size: 1.5rem;
            font-weight: 900;
        }

        .faq-answer {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
            display: none;
        }

        .faq-answer.active {
            display: block;
        }

        footer {
            background-color: #f5f5f5;
            border-top: 4px solid #121212;
            padding: 3rem 1.5rem 1.5rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h4 {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            color: #121212;
        }

        .footer-section a {
            display: block;
            color: #121212;
            text-decoration: none;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #D02020;
        }

        .footer-bottom {
            border-top: 4px solid #121212;
            padding-top: 1.5rem;
            text-align: center;
            color: #121212;
            font-weight: 500;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .container {
                margin: 2rem auto;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .faq-item {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <a href="/" class="navbar-logo">
            <div style="width: 32px; height: 32px; background-color: #D02020; border: 3px solid #121212; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 1.2rem;">S</div>
            Skillzy
        </a>
        <div class="navbar-links">
            <a href="/">Back to Home</a>
        </div>
    </nav>

    <!-- FAQ Section -->
    <div class="container">
        <h1 class="page-title">Frequently Asked Questions</h1>
        <p class="page-subtitle">Find answers to common questions about Skillzy</p>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>What is Skillzy and how does it work?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                Skillzy is a peer-to-peer skill exchange platform where users can share their expertise and learn from others using Skillzy Coins as currency. You can list your skills, browse available courses, connect with instructors, and earn or spend coins based on your transactions.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>How do I earn Skillzy Coins?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                You earn Skillzy Coins by offering your skills to other users and completing transactions. Every time someone purchases a course or skill from you, you earn coins. You can also get coins through various platform activities and promotions.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>Can I withdraw my Skillzy Coins?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                Yes! You can withdraw your earned Skillzy Coins from your wallet. Simply navigate to your wallet section and follow the withdrawal process. Withdrawals are processed within 3-5 business days.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>Is there a fee for using Skillzy?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                Skillzy is free to join and create an account. There are minimal platform fees when you receive payments, which support the maintenance and development of the platform.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>How do I purchase courses or skills?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                Browse the available skills in the marketplace, click on a course you're interested in, and use your Skillzy Coins to purchase. Once purchased, you can access the course materials and communicate with the instructor.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>How does the messaging system work?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                Once you purchase a course or are contacted by a buyer, you'll have access to the instant messaging system to communicate directly with other users. You can share resources, schedule lessons, and coordinate the learning process in real-time.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>Is my personal information safe on Skillzy?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                Yes, we take security very seriously. All transactions are encrypted and secure. Your personal information is protected according to industry standards and privacy regulations. You can control what information you share with other users.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>How are disputes and complaints handled?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                If you have an issue with a transaction or another user, you can file a report through our support system. Our team will review the complaint and work toward a fair resolution within 7 business days.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>Can I cancel or refund a purchase?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                Refunds are possible if you haven't accessed the course materials. If you're unsatisfied with a purchase, contact the instructor or submit a support request. Refund requests are reviewed within 3 business days.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>How do I contact support?</span>
                <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
                You can reach our support team through the Contact Us page, or by sending an email to our support email address. We typically respond within 24-48 hours. You can also check our support section for additional resources and guides.
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background-color: #f5f5f5; border-top: 4px solid #121212; padding: 1rem;">
        <div style="max-width: 1200px; margin: 0 auto; width: 100%; padding: 1rem;">
            <div style="display: grid; grid-template-columns: auto 1fr 1fr; gap: 6rem; align-items: start; margin-bottom: 0.5rem;">
                
                <!-- Geometric Shapes -->
                <div style="display: flex; gap: 1.5rem; align-items: center;">
                    <div style="width: 60px; height: 60px; background-color: #D02020; border-radius: 50%; border: 3px solid #121212;"></div>
                    <div style="width: 60px; height: 60px; background-color: #1040C0; border: 3px solid #121212; clip-path: polygon(50% 0%, 100% 100%, 0% 100%);"></div>
                    <div style="width: 60px; height: 60px; background-color: #F0C020; border: 3px solid #121212;"></div>
                </div>

                <!-- Navigation Column -->
                <div>
                    <h4 style="color: #121212; font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1.5rem;">Navigation</h4>
                    <div>
                        <a href="/" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 600; font-size: 0.95rem; margin-bottom: 0.8rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">Home</a>
                        <a href="/listings" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 600; font-size: 0.95rem; margin-bottom: 0.8rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">Browse Skills</a>
                        <a href="/purchases" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 600; font-size: 0.95rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">My Purchases</a>
                    </div>
                </div>

                <!-- About Column -->
                <div>
                    <h4 style="color: #121212; font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1.5rem;">About</h4>
                    <div>
                        <a href="/about" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 600; font-size: 0.95rem; margin-bottom: 0.8rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">About Us</a>
                        <a href="/contact" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 600; font-size: 0.95rem; margin-bottom: 0.8rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">Contact Us</a>
                        <a href="/faq" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 600; font-size: 0.95rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">FAQ</a>
                    </div>
                </div>
            </div>

            <!-- Bottom -->
            <div style="padding-top: 0.5rem; text-align: center;">
                <p style="color: #121212; font-size: 0.95rem; font-weight: 600; margin: 0;">&copy; 2026 Skillzy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            const toggle = element.querySelector('.faq-toggle');
            
            answer.classList.toggle('active');
            toggle.textContent = answer.classList.contains('active') ? '−' : '+';
        }
    </script>
</body>
</html>
