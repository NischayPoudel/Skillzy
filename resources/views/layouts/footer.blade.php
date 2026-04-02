<footer class="bg-bauhaus-black text-white section-divider mt-auto">
    <div class="section-container">
        <div class="grid-1-2-3 gap-8 py-12">
            <!-- Brand -->
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-bauhaus-red rounded-full"></div>
                <div class="w-12 h-12 bg-bauhaus-blue"></div>
                <div class="w-12 h-12 bg-bauhaus-yellow"></div>
            </div>

            <!-- Links -->
            <div>
                <h4 class="uppercase-label mb-4">Navigation</h4>
                <div class="space-y-2">
                    <a href="{{ route('listings.index') }}" class="block text-gray-300 hover:text-white transition-colors">Browse Skills</a>
                    <a href="{{ route('purchases.index') }}" class="block text-gray-300 hover:text-white transition-colors">My Purchases</a>
                    <a href="{{ route('wallet.show') }}" class="block text-gray-300 hover:text-white transition-colors">Wallet</a>
                </div>
            </div>

            <!-- Info -->
            <div>
                <h4 class="uppercase-label mb-4">About</h4>
                <p class="text-gray-300 text-sm">Skillzy is a peer-to-peer skill exchange platform using Skillzy Coins as currency.</p>
            </div>
        </div>

        <!-- Bottom -->
        <div class="border-t-4 border-bauhaus-red pt-6 pb-4 flex justify-between items-center">
            <p class="text-gray-400 text-sm">&copy; 2026 Skillzy. All rights reserved.</p>
            @auth
                <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Profile</a>
            @endauth
        </div>
    </div>
</footer>
