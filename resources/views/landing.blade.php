<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skillzy - Share Skills, Earn Coins</title>
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

        .hero {
            background-color: white;
            border-bottom: 4px solid #121212;
            padding: 3rem 1.5rem;
            min-height: 600px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 20%;
            right: -50px;
            width: 200px;
            height: 200px;
            background-color: #D02020;
            opacity: 0.1;
            transform: rotate(45deg);
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: 10%;
            left: -30px;
            width: 150px;
            height: 150px;
            background-color: #1040C0;
            opacity: 0.1;
            border-radius: 50%;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: clamp(2rem, 8vw, 4rem);
            font-weight: 900;
            line-height: 1;
            margin-bottom: 1.5rem;
            letter-spacing: -2px;
        }

        .hero-content .highlight {
            color: #D02020;
            background-color: #F0C020;
            padding: 0 0.5rem;
            display: inline-block;
        }

        .hero-content p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
            margin-bottom: 2rem;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 700;
            border: 4px solid #121212;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background-color: #D02020;
            color: white;
        }

        .btn-primary:hover {
            background-color: #B01818;
            box-shadow: 6px 6px 0px 0px rgba(18, 18, 18, 0.1);
            transform: translate(-2px, -2px);
        }

        .btn-secondary {
            background-color: white;
            color: #121212;
        }

        .btn-secondary:hover {
            background-color: #F0F0F0;
            box-shadow: 6px 6px 0px 0px rgba(18, 18, 18, 0.1);
            transform: translate(-2px, -2px);
        }

        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .shape {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid #121212;
            font-weight: 900;
        }

        .shape-large {
            width: 120px;
            height: 120px;
        }

        .shape-medium {
            width: 80px;
            height: 80px;
        }

        .shape-red {
            background-color: #D02020;
            color: white;
        }

        .shape-blue {
            background-color: #1040C0;
            color: white;
        }

        .shape-yellow {
            background-color: #F0C020;
            color: #121212;
        }

        .shape-circle {
            border-radius: 50%;
        }

        /* Features Section */
        .features {
            padding: 4rem 1.5rem;
            background-color: #F0F0F0;
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .section-title {
            font-size: clamp(1.8rem, 5vw, 3rem);
            font-weight: 900;
            text-align: center;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background-color: white;
            padding: 2rem;
            border: 4px solid #121212;
            box-shadow: 6px 6px 0px 0px rgba(18, 18, 18, 0.05);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translate(-4px, -4px);
            box-shadow: 10px 10px 0px 0px rgba(18, 18, 18, 0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 1.5rem;
            border: 3px solid #121212;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .feature-desc {
            color: #666;
            line-height: 1.6;
        }

        /* How It Works */
        .how-it-works {
            background-color: white;
            padding: 4rem 1.5rem;
            border-top: 4px solid #121212;
            border-bottom: 4px solid #121212;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .step {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background-color: #D02020;
            color: white;
            border: 4px solid #121212;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 900;
            margin: 0 auto 1.5rem;
            box-shadow: 4px 4px 0px 0px rgba(18, 18, 18, 0.1);
        }

        .step-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .step-desc {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            background-color: #F0F0F0;
            padding: 4rem 1.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .stat-box {
            background-color: white;
            padding: 2rem;
            border: 4px solid #121212;
            text-align: center;
            box-shadow: 4px 4px 0px 0px rgba(18, 18, 18, 0.05);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            color: #D02020;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            font-weight: 600;
            color: #121212;
        }

        /* Testimonials */
        .testimonials {
            background-color: white;
            padding: 4rem 1.5rem;
            border-top: 4px solid #121212;
            border-bottom: 4px solid #121212;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .testimonial-card {
            background-color: #F0F0F0;
            padding: 2rem;
            border: 4px solid #121212;
            box-shadow: 4px 4px 0px 0px rgba(18, 18, 18, 0.05);
        }

        .testimonial-text {
            font-style: italic;
            color: #333;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .testimonial-author {
            font-weight: 700;
            color: #121212;
            margin-bottom: 0.25rem;
        }

        .testimonial-role {
            color: #D02020;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* CTA Section */
        .cta-section {
            background-color: #121212;
            color: white;
            padding: 4rem 1.5rem;
            text-align: center;
            border-bottom: 4px solid #D02020;
        }

        .cta-section h2 {
            font-size: clamp(1.8rem, 5vw, 2.8rem);
            font-weight: 900;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .cta-section p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-cta {
            padding: 1rem 2.5rem;
            font-size: 1rem;
            font-weight: 700;
            border: 4px solid white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-cta-primary {
            background-color: #D02020;
            color: white;
            border-color: #D02020;
        }

        .btn-cta-primary:hover {
            background-color: #B01818;
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px rgba(255, 255, 255, 0.2);
        }

        .btn-cta-secondary {
            background-color: transparent;
            color: white;
            border-color: white;
        }

        .btn-cta-secondary:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translate(-2px, -2px);
        }

        /* Footer */
        .footer {
            background-color: #f5f5f5;
            border-top: 4px solid #121212;
            padding: 3rem 1.5rem 1.5rem;
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
        }

        .geometric-shapes {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
        }

        .shape-sm {
            width: 20px;
            height: 20px;
            border: 2px solid #121212;
        }

        .shape-sm.red {
            background-color: #D02020;
        }

        .shape-sm.blue {
            background-color: #1040C0;
        }

        .shape-sm.yellow {
            background-color: #F0C020;
        }

        .shape-sm.circle {
            border-radius: 50%;
        }

        /* Navigation */
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

        .navbar-links button {
            background: none;
            border: none;
            color: #121212;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .hero-container {
                grid-template-columns: 1fr;
            }

            .hero {
                min-height: auto;
                padding: 2rem 1.5rem;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .navbar-links {
                gap: 1rem;
                font-size: 0.85rem;
            }

            .features-grid,
            .steps-grid,
            .testimonials-grid,
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .btn-cta {
                width: 100%;
                text-align: center;
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
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; color: #121212; font-weight: 600; font-size: 0.95rem;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Log In</a>
                <a href="{{ route('register') }}" style="padding: 0.7rem 1.5rem; background-color: #D02020; color: white; border: 2px solid #121212; font-weight: 700; border-radius: 0;">Sign Up</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Share Your <span class="highlight">Skills</span>, Earn <span class="highlight">Coins</span></h1>
                <p>Connect with a community of learners and experts. Exchange skills peer-to-peer using Skillzy Coins as currency. No money needed—just your expertise.</p>
                <div class="hero-cta">
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started Free</a>
                    <a href="#features" class="btn btn-secondary">Learn More</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="shape shape-large shape-red" style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%);"></div>
                <div class="shape shape-medium shape-blue" style="border-radius: 50%;"></div>
                <div class="shape shape-large shape-yellow"></div>
            </div>
        </div>
    </section>

    <!-- CTA Section at Top -->
    <section class="cta-section">
        <div class="section-container">
            <h2>Ready to Start Your Journey?</h2>
            <p>Join thousands of learners and experts building skills together. Start earning Skillzy Coins today—completely free.</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn-cta btn-cta-primary">Create Free Account</a>
                <a href="{{ route('listings.index') }}" class="btn-cta btn-cta-secondary">Browse Skills</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-container">
            <h2 class="section-title">Why Choose Skillzy?</h2>
            <p class="section-subtitle">A seamless platform for skill exchange, community building, and personal growth</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon" style="background-color: #F0C020; border-color: #121212;">$</div>
                    <h3 class="feature-title">Earn Coins</h3>
                    <p class="feature-desc">Get rewarded for sharing your skills. Earn Skillzy Coins with every successful transaction and withdraw or reinvest.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon" style="background-color: #D02020; color: white; border-color: #121212;">+</div>
                    <h3 class="feature-title">Community Focused</h3>
                    <p class="feature-desc">Join a thriving community of learners and experts. Showcase your expertise and build meaningful connections.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon" style="background-color: #1040C0; color: white; border-color: #121212;">✓</div>
                    <h3 class="feature-title">Secure & Trusted</h3>
                    <p class="feature-desc">All transactions are secure. Get ratings and reviews to build trust with your peers and students.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon" style="background-color: #F0C020; border-color: #121212;">◆</div>
                    <h3 class="feature-title">Global Marketplace</h3>
                    <p class="feature-desc">Learn from experts worldwide and teach people across the globe. No geographic limitations.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon" style="background-color: #D02020; color: white; border-color: #121212;">✎</div>
                    <h3 class="feature-title">Easy to Use</h3>
                    <p class="feature-desc">Simple interface makes it easy to list your skills, find courses, and manage your account seamlessly.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon" style="background-color: #1040C0; color: white; border-color: #121212;">→</div>
                    <h3 class="feature-title">Instant Messaging</h3>
                    <p class="feature-desc">Connect directly with learners and instructors. Coordinate lessons and share resources in real-time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="how-it-works">
        <div class="section-container">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Get started in just 4 simple steps</p>

            <div class="steps-grid">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Create Account</h3>
                    <p class="step-desc">Sign up with your email and set up your profile. Add your skills and interests.</p>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Browse or List</h3>
                    <p class="step-desc">Offer your skills or browse available courses from other experts in the community.</p>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Connect & Learn</h3>
                    <p class="step-desc">Chat with instructors, purchase courses, and start your learning journey with Skillzy Coins.</p>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <h3 class="step-title">Earn & Grow</h3>
                    <p class="step-desc">Get reviews, build reputation, and earn more coins as you help others learn.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="section-container">
            <h2 class="section-title">Join Our Growing Community</h2>

            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-number">5K+</div>
                    <div class="stat-label">Active Users</div>
                </div>

                <div class="stat-box">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Skills Available</div>
                </div>

                <div class="stat-box">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Transactions</div>
                </div>

                <div class="stat-box">
                    <div class="stat-number">4.8★</div>
                    <div class="stat-label">Average Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="section-container">
            <h2 class="section-title">What Users Say</h2>
            <p class="section-subtitle">Real stories from our community members</p>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Skillzy help me learn graphic design without spending money. The community is amazing and supportive!"</p>
                    <div class="testimonial-author">Sarah M.</div>
                    <div class="testimonial-role">Graphic Designer</div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">"I earn coins teaching coding. It's flexible, rewarding, and I've met people from around the world!"</p>
                    <div class="testimonial-author">Rajesh K.</div>
                    <div class="testimonial-role">Software Developer</div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">"The platform is incredibly user-friendly. I helped my friend learn photography and earned coins in the process!"</p>
                    <div class="testimonial-author">Emma T.</div>
                    <div class="testimonial-role">Photography Instructor</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-bauhaus-black text-white section-divider mt-auto" style="background-color: #f5f5f5; border-top: 4px solid #121212; padding: 1rem;">
        <div class="section-container" style="max-width: 1200px; margin: 0 auto; width: 100%; padding: 1rem;">
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
                    <div style="space-y: 1rem;">
                        <a href="{{ route('listings.index') }}" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 600; font-size: 0.95rem; margin-bottom: 0.8rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">Browse Skills</a>
                        <a href="{{ route('purchases.index') }}" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 600; font-size: 0.95rem; margin-bottom: 0.8rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">My Purchases</a>
                        <a href="{{ route('wallet.show') }}" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 600; font-size: 0.95rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">Wallet</a>
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
</body>
</html>
