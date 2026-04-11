<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contact Us - Skillzy</title>
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
            max-width: 700px;
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

        .contact-form {
            background-color: white;
            padding: 3rem;
            border: 4px solid #121212;
            box-shadow: 6px 6px 0px 0px rgba(18, 18, 18, 0.05);
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 3px solid #121212;
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            background-color: #F0F0F0;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            background-color: white;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background-color: #D02020;
            color: white;
            border: 4px solid #121212;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
            font-family: 'Outfit', sans-serif;
        }

        .btn-submit:hover {
            background-color: #B01818;
            box-shadow: 6px 6px 0px 0px rgba(18, 18, 18, 0.1);
            transform: translate(-2px, -2px);
        }

        .back-link {
            display: inline-block;
            color: #121212;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 2rem;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #D02020;
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

            .contact-form {
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

    <!-- Contact Section -->
    <div class="container">
        <h1 class="page-title">Contact Us</h1>
        <p class="page-subtitle">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>

        <form class="contact-form" method="POST" action="#" onsubmit="return handleSubmit(event)">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Your full name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="your.email@example.com">
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required placeholder="What is this about?">
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" required placeholder="Tell us more..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Send Message</button>
        </form>
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
        function handleSubmit(event) {
            event.preventDefault();
            alert('Thank you for contacting us! We will get back to you soon.');
            event.target.reset();
            return false;
        }
    </script>
</body>
</html>
