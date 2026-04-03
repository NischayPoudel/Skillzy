<x-app-layout>
    <style>
        .geometric-accent {
            position: relative;
        }
        
        .geometric-accent::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: rgba(208, 32, 32, 0.1);
        }

        .color-rotate-1 { background: #D02020; }
        .color-rotate-2 { background: #1040C0; }
        .color-rotate-3 { background: #F0C020; }
        .color-rotate-4 { background: #10B981; }

        .stat-card-accent {
            position: relative;
            overflow: hidden;
        }

        .stat-card-accent::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: -50%;
            width: 200%;
            height: 4px;
            background: #D02020;
        }

        .feature-icon {
            font-size: 4rem;
            font-weight: 900;
            color: #D02020;
        }

        .team-card {
            position: relative;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 3px solid #121212;
        }

        .team-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(208, 32, 32, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .team-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .team-card:hover::before {
            opacity: 1;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .value-card {
            position: relative;
            padding: 32px;
            background: white;
            border: 3px solid #121212;
            transition: all 0.3s ease;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #D02020;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .value-card:hover::before {
            transform: scaleX(1);
        }

        .value-number {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 1rem;
            opacity: 0.15;
        }

        .section-divider {
            height: 8px;
            background: linear-gradient(90deg, #D02020 25%, #1040C0 50%, #F0C020 75%, #121212 100%);
            margin: 3rem 0;
            border-radius: 4px;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
            color: #121212;
        }

        .impact-card {
            position: relative;
            padding: 2rem;
            background: white;
            border: 3px solid #121212;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .impact-badge {
            width: 100%;
            height: 120px;
            background: #1040C0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 6px 12px rgba(16, 64, 192, 0.2);
        }

        .impact-number {
            font-size: 2.5rem;
            font-weight: 900;
            color: white;
        }

        .impact-label {
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #666;
            letter-spacing: 0.5px;
        }

        .support-card {
            background: white;
            border: 3px solid #121212;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .support-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(208, 32, 32, 0.1);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 0;
        }

        .support-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
            border: 3px solid #D02020;
        }

        .support-card:hover::after {
            opacity: 1;
        }

        .cta-button {
            padding: 1rem 2.5rem;
            font-weight: 700;
            text-transform: uppercase;
            border: 3px solid #121212;
            letter-spacing: 1px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-size: 0.95rem;
        }

        .cta-button-primary {
            background: #D02020;
            color: white;
        }

        .cta-button-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(208, 32, 32, 0.3);
        }

        .cta-button-secondary {
            background: white;
            color: #121212;
        }

        .cta-button-secondary:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            background: #F0C020;
        }
    </style>

    <div class="max-w-7xl mx-auto">

        <!-- Hero Section with Geometric Design -->
        <section class="py-16 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-100 rounded-full opacity-30 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-100 rounded-full opacity-30 blur-3xl"></div>
            
            <div class="relative z-10">
                <p style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #121212; margin-bottom: 1rem;">Welcome to Skillzy</p>
                <h1 class="hero-title mb-6">Connecting Skills, Empowering Lives</h1>
                <p style="font-size: 1.25rem; line-height: 1.8; color: #555; max-width: 700px;">
                    Skillzy revolutionizes skill-sharing through a peer-to-peer platform that empowers individuals to monetize their expertise and learn from global experts. We're building a future where knowledge knows no boundaries and talent is fairly rewarded.
                </p>
            </div>
        </section>

        <div class="section-divider"></div>

        <!-- Impact Section -->
        <section>
            <h2 style="font-size: 2.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3rem; text-align: center;">Our Global Impact</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem;">
                @foreach($stats as $stat)
                <div class="impact-card">
                    <div class="impact-badge">
                        <span class="impact-number">{{ $stat['value'] }}</span>
                    </div>
                    <p class="impact-label">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <div class="section-divider"></div>

        <!-- Features Section with Color Rotation -->
        <section>
            <h2 style="font-size: 2.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3rem; text-align: center;">Why Choose Skillzy</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem;">
                @foreach($features as $index => $feature)
                <div style="background: white; border: 3px solid #121212; padding: 2.5rem; transition: all 0.3s ease; position: relative;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <div style="width: 70px; height: 70px; background: {{ ['#D02020', '#1040C0', '#F0C020', '#10B981', '#D02020', '#1040C0'][$index % 4] }}; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; color: white; font-weight: 900; font-size: 1.75rem;">
                        {{ $feature['icon'] }}
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 900; text-transform: uppercase; margin-bottom: 1rem; color: #121212; letter-spacing: 0.5px;">{{ $feature['title'] }}</h3>
                    <p style="color: #666; line-height: 1.6; font-size: 0.95rem;">{{ $feature['description'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <div class="section-divider"></div>

        <!-- Team Section -->
        <section>
            <h2 style="font-size: 2.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3rem; text-align: center;">Meet Our Visionary Team</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 2rem;">
                @foreach($teamMembers as $index => $member)
                <div class="team-card" style="padding: 2rem; background: {{ ['#FFF8F8', '#F8F8FF', '#FFFFF8', '#F8FFF8'][$index % 4] }};">
                    <div style="width: 80px; height: 80px; background: #F0C020; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 1.5rem; margin-bottom: 1.5rem;">
                        {{ $member['icon'] }}
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 900; text-transform: uppercase; color: #121212; margin-bottom: 0.5rem; letter-spacing: 0.5px;">{{ $member['name'] }}</h3>
                    <p style="font-size: 0.85rem; font-weight: 700; color: #F0C020; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">{{ $member['role'] }}</p>
                    <p style="color: #666; font-size: 0.9rem; line-height: 1.6;">{{ $member['bio'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <div class="section-divider"></div>

        <!-- Values Section -->
        <section>
            <h2 style="font-size: 2.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3rem; text-align: center;">Our Core Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-number">01</div>
                    <h3 style="font-size: 1.5rem; font-weight: 900; text-transform: uppercase; color: #D02020; margin-bottom: 1rem; letter-spacing: 0.5px;">Trust</h3>
                    <p style="color: #666; line-height: 1.7;">We prioritize transparency and honesty in every interaction. Our platform is built on integrity, ensuring users can confidently conduct transactions with peace of mind.</p>
                </div>
                <div class="value-card">
                    <div class="value-number">02</div>
                    <h3 style="font-size: 1.5rem; font-weight: 900; text-transform: uppercase; color: #1040C0; margin-bottom: 1rem; letter-spacing: 0.5px;">Quality</h3>
                    <p style="color: #666; line-height: 1.7;">We maintain exceptional standards through verification, ratings, reviews, and continuous community feedback to ensure only the best skills are shared.</p>
                </div>
                <div class="value-card">
                    <div class="value-number">03</div>
                    <h3 style="font-size: 1.5rem; font-weight: 900; text-transform: uppercase; color: #F0C020; margin-bottom: 1rem; letter-spacing: 0.5px;">Fairness</h3>
                    <p style="color: #666; line-height: 1.7;">Equal opportunities for all users. Our transparent coin-based system ensures fair pricing, ethical transactions, and equitable value distribution.</p>
                </div>
            </div>
        </section>

        <div class="section-divider"></div>

        <!-- Support Section -->
        <section>
            <h2 style="font-size: 2.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3rem; text-align: center;">We're Here to Help</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div class="support-card">
                    <div style="font-size: 3.5rem; margin-bottom: 1.5rem;">❓</div>
                    <h3 style="font-size: 1.25rem; font-weight: 900; text-transform: uppercase; color: #121212; margin-bottom: 1rem; letter-spacing: 0.5px;">FAQs</h3>
                    <p style="color: #666; line-height: 1.7; margin-bottom: 1.5rem;">Find quick answers to common questions about using Skillzy, managing your profile, and completing transactions.</p>
                    <a href="{{ route('support.show') }}" style="display: inline-block; padding: 0.75rem 1.5rem; background: #1040C0; color: white; text-decoration: none; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; border: 2px solid #1040C0; transition: all 0.3s ease; letter-spacing: 0.5px;" onmouseover="this.style.background='#0D32A4';" onmouseout="this.style.background='#1040C0';">Browse FAQs</a>
                </div>
                <div class="support-card">
                    <div style="font-size: 3.5rem; margin-bottom: 1.5rem;">📧</div>
                    <h3 style="font-size: 1.25rem; font-weight: 900; text-transform: uppercase; color: #121212; margin-bottom: 1rem; letter-spacing: 0.5px;">Email Support</h3>
                    <p style="color: #666; line-height: 1.7; margin-bottom: 1.5rem;">Reach out to our dedicated support team for detailed assistance. We typically respond within 24 hours.</p>
                    <a href="mailto:support@skillzy.com" style="display: inline-block; padding: 0.75rem 1.5rem; background: #D02020; color: white; text-decoration: none; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; border: 2px solid #D02020; transition: all 0.3s ease; letter-spacing: 0.5px;" onmouseover="this.style.background='#B01818';" onmouseout="this.style.background='#D02020';">Contact Us</a>
                </div>
                <div class="support-card">
                    <div style="font-size: 3.5rem; margin-bottom: 1.5rem;">💬</div>
                    <h3 style="font-size: 1.25rem; font-weight: 900; text-transform: uppercase; color: #121212; margin-bottom: 1rem; letter-spacing: 0.5px;">Live Chat</h3>
                    <p style="color: #666; line-height: 1.7; margin-bottom: 1.5rem;">Chat with our support specialists for real-time assistance. Available during business hours for immediate help.</p>
                    <a href="#" style="display: inline-block; padding: 0.75rem 1.5rem; background: #121212; color: white; text-decoration: none; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; border: 2px solid #121212; transition: all 0.3s ease; letter-spacing: 0.5px;" onmouseover="this.style.background='#333';" onmouseout="this.style.background='#121212';">Start Chat</a>
                </div>
            </div>
        </section>

        <div class="section-divider"></div>

        <!-- CTA Section -->
        <section style="text-align: center; padding: 4rem 2rem;">
            <h2 style="font-size: 2.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; color: #121212;">Join the Skillzy Revolution</h2>
            <p style="font-size: 1.125rem; color: #666; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.8;">Start sharing your expertise or learning from world-class professionals. It only takes minutes to join thousands of skilled individuals.</p>
            <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('register') }}" class="cta-button cta-button-primary">
                    Get Started Now
                </a>
                <a href="{{ route('listings.index') }}" class="cta-button cta-button-secondary">
                    Explore Skills
                </a>
            </div>
        </section>

    </div>
</x-app-layout>
