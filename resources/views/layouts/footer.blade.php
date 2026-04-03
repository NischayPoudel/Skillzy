<footer class="bg-bauhaus-black text-white section-divider mt-auto" style="background-color: #f5f5f5; border-top: 4px solid #121212;">
    <div class="section-container">
        <div class="grid-1-2-3 gap-8 py-12">
            <!-- Brand -->
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-bauhaus-red rounded-full"></div>
                <div class="shape-blue-triangle"></div>
                <div class="w-12 h-12 bg-bauhaus-yellow"></div>
            </div>

            <!-- Links -->
            <div>
                <h4 style="color: #121212; font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Navigation</h4>
                <div class="space-y-2">
                    <a href="{{ route('listings.index') }}" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 500; font-size: 0.95rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">Browse Skills</a>
                    <a href="{{ route('purchases.index') }}" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 500; font-size: 0.95rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">My Purchases</a>
                    <a href="{{ route('wallet.show') }}" style="display: block; color: #121212; text-decoration: none; transition: all 0.3s ease; font-weight: 500; font-size: 0.95rem;" onmouseover="this.style.color='#D02020';" onmouseout="this.style.color='#121212';">Wallet</a>
                </div>
            </div>

            <!-- Info -->
            <div>
                <h4 style="color: #121212; font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">About</h4>
                <p style="color: #333; font-size: 0.95rem; line-height: 1.6;">Skillzy is a peer-to-peer skill exchange platform using Skillzy Coins as currency.</p>
            </div>
        </div>

        <!-- Bottom -->
        <div class="border-t-4 border-bauhaus-red pt-6 pb-4 text-center">
            <p style="color: #121212; font-size: 0.95rem; font-weight: 500;">&copy; 2026 Skillzy. All rights reserved.</p>
        </div>
    </div>
</footer>
