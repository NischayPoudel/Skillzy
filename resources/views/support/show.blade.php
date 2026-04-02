<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl sm:text-6xl font-black uppercase tracking-tighter">Support</h1>
                <p class="text-gray-600 mt-2 text-sm">We're here to help you</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-12">

        <!-- Contact Methods Section -->
        <section>
            <h2 class="text-3xl font-black uppercase tracking-tight mb-8 pb-4 border-b-4 border-bauhaus-black">Get in Touch</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($contactMethods as $method)
                <div class="bg-white border-4 border-bauhaus-black p-6 hover:shadow-lg transition-all">
                    <div class="text-4xl mb-4">{{ $method['icon'] }}</div>
                    <h3 class="text-lg font-black uppercase tracking-tight mb-2">{{ $method['title'] }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ $method['description'] }}</p>
                    <div class="bg-bauhaus-yellow p-3 border-2 border-bauhaus-black">
                        <p class="font-bold text-sm">{{ $method['contact'] }}</p>
                        <p class="text-xs text-gray-600 mt-1">Response: {{ $method['response_time'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- FAQs Section -->
        <section>
            <h2 class="text-3xl font-black uppercase tracking-tight mb-8 pb-4 border-b-4 border-bauhaus-black">Frequently Asked Questions</h2>
            <div class="space-y-4">
                @foreach($faqs as $faq)
                <details class="group bg-white border-4 border-bauhaus-black p-6 cursor-pointer hover:bg-gray-50 transition-colors">
                    <summary class="flex items-start justify-between font-black uppercase tracking-tight text-lg">
                        <span class="flex-1 text-left">{{ $faq['question'] }}</span>
                        <span class="ml-4 text-2xl group-open:rotate-180 transition-transform">+</span>
                    </summary>
                    <p class="mt-4 text-gray-700 leading-relaxed border-t-2 border-bauhaus-black pt-4">
                        {{ $faq['answer'] }}
                    </p>
                </details>
                @endforeach
            </div>
        </section>

        <!-- Contact Form Section -->
        <section class="bg-bauhaus-black text-white p-8 border-4 border-bauhaus-black">
            <h2 class="text-3xl font-black uppercase tracking-tight mb-6">Send us a Message</h2>
            <form class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" placeholder="Your Name" class="w-full p-4 border-2 border-white bg-transparent text-white placeholder-gray-300 font-bold uppercase" required>
                    <input type="email" placeholder="Your Email" class="w-full p-4 border-2 border-white bg-transparent text-white placeholder-gray-300 font-bold uppercase" required>
                </div>
                <input type="text" placeholder="Subject" class="w-full p-4 border-2 border-white bg-transparent text-white placeholder-gray-300 font-bold uppercase" required>
                <textarea placeholder="Your Message" rows="6" class="w-full p-4 border-2 border-white bg-transparent text-white placeholder-gray-300 font-bold uppercase" required></textarea>
                <button type="submit" class="w-full py-4 bg-bauhaus-yellow text-bauhaus-black font-black uppercase tracking-tight border-2 border-bauhaus-black hover:bg-white transition-colors">
                    Send Message
                </button>
            </form>
        </section>

    </div>
</x-app-layout>
