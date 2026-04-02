<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-12">

        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-bauhaus-red to-bauhaus-blue text-white p-8 border-4 border-bauhaus-black">
            <h2 class="text-3xl font-black uppercase tracking-tight mb-4">Our Mission</h2>
            <p class="text-lg leading-relaxed">
                Skillzy is a peer-to-peer platform dedicated to empowering individuals by connecting skill providers with skill seekers. We believe everyone has valuable knowledge to share and deserves fair compensation for their expertise.
            </p>
        </section>

        <!-- Stats Section -->
        <section>
            <h2 class="text-3xl font-black uppercase tracking-tight mb-8 pb-4 border-b-4 border-bauhaus-black">Our Impact</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($stats as $stat)
                <div class="bg-white border-4 border-bauhaus-black p-6 text-center hover:shadow-lg transition-all">
                    <div class="text-4xl font-black text-bauhaus-red mb-2">{{ $stat['value'] }}</div>
                    <p class="font-bold uppercase tracking-tight text-sm">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Features Section -->
        <section>
            <h2 class="text-3xl font-black uppercase tracking-tight mb-8 pb-4 border-b-4 border-bauhaus-black">Why Choose Skillzy</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($features as $feature)
                <div class="bg-white border-4 border-bauhaus-black p-6">
                    <div class="text-5xl mb-4">{{ $feature['icon'] }}</div>
                    <h3 class="text-lg font-black uppercase tracking-tight mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $feature['description'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Team Section -->
        <section>
            <h2 class="text-3xl font-black uppercase tracking-tight mb-8 pb-4 border-b-4 border-bauhaus-black">Meet Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($teamMembers as $member)
                <div class="bg-white border-4 border-bauhaus-black p-6 hover:bg-bauhaus-yellow transition-colors">
                    <div class="text-6xl mb-4">{{ $member['icon'] }}</div>
                    <h3 class="text-lg font-black uppercase tracking-tight">{{ $member['name'] }}</h3>
                    <p class="text-sm font-bold text-bauhaus-red mt-1">{{ $member['role'] }}</p>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $member['bio'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Values Section -->
        <section class="bg-bauhaus-black text-white p-8 border-4 border-bauhaus-black">
            <h2 class="text-3xl font-black uppercase tracking-tight mb-6">Our Core Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-xl font-black uppercase tracking-tight mb-2 text-bauhaus-yellow">Trust</h3>
                    <p>We prioritize transparency and honesty in every interaction on our platform.</p>
                </div>
                <div>
                    <h3 class="text-xl font-black uppercase tracking-tight mb-2 text-bauhaus-yellow">Quality</h3>
                    <p>We maintain high standards through ratings, reviews, and community feedback.</p>
                </div>
                <div>
                    <h3 class="text-xl font-black uppercase tracking-tight mb-2 text-bauhaus-yellow">Fairness</h3>
                    <p>Equal opportunities for all, with fair pricing and transparent coin system.</p>
                </div>
            </div>
        </section>

        <!-- Support Section -->
        <section>
            <h2 class="text-3xl font-black uppercase tracking-tight mb-8 pb-4 border-b-4 border-bauhaus-black">Need Help?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white border-4 border-bauhaus-black p-6 hover:bg-bauhaus-yellow transition-colors">
                    <div class="text-5xl mb-4">❓</div>
                    <h3 class="text-lg font-black uppercase tracking-tight mb-2">FAQ</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Browse our frequently asked questions to find quick answers to common issues.</p>
                    <a href="{{ route('support.show') }}" class="inline-block px-4 py-2 bg-bauhaus-blue text-white font-bold uppercase text-sm">View FAQs</a>
                </div>
                <div class="bg-white border-4 border-bauhaus-black p-6 hover:bg-bauhaus-yellow transition-colors">
                    <div class="text-5xl mb-4">📧</div>
                    <h3 class="text-lg font-black uppercase tracking-tight mb-2">Email Support</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Got a question? Reach out to our support team at support@skillzy.com for assistance.</p>
                    <a href="mailto:support@skillzy.com" class="inline-block px-4 py-2 bg-bauhaus-red text-white font-bold uppercase text-sm">Contact Us</a>
                </div>
                <div class="bg-white border-4 border-bauhaus-black p-6 hover:bg-bauhaus-yellow transition-colors">
                    <div class="text-5xl mb-4">💬</div>
                    <h3 class="text-lg font-black uppercase tracking-tight mb-2">Live Chat</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Chat with our support specialists in real-time for immediate help with your concerns.</p>
                    <a href="#" class="inline-block px-4 py-2 bg-bauhaus-black text-white font-bold uppercase text-sm">Open Chat</a>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="text-center py-12">
            <h2 class="text-3xl font-black uppercase tracking-tight mb-4">Ready to Join Us?</h2>
            <p class="text-lg text-gray-600 mb-8">Start sharing your skills or learning from experts today</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-bauhaus-red text-white font-black uppercase tracking-tight border-2 border-bauhaus-black hover:bg-bauhaus-black transition-colors">
                    Sign Up Now
                </a>
                <a href="{{ route('listings.index') }}" class="px-8 py-4 bg-white text-bauhaus-black font-black uppercase tracking-tight border-2 border-bauhaus-black hover:bg-bauhaus-yellow transition-colors">
                    Browse Skills
                </a>
            </div>
        </section>

    </div>
</x-app-layout>
