<x-app-layout>
    <style>
        @media (max-width: 768px) {
            .wallet-container {
                max-width: 100% !important;
                padding: 0 1rem !important;
            }
            .wallet-header h1 {
                font-size: 2rem !important;
            }
            .wallet-header .emoji {
                display: none !important;
            }
            .balance-card {
                justify-content: flex-start !important;
            }
            .balance-emoji {
                font-size: 4rem !important;
            }
            .transaction-card {
                flex-direction: column !important;
                gap: 1rem !important;
            }
            .transaction-left {
                width: 100% !important;
                flex-direction: row !important;
            }
            .transaction-right {
                width: 100% !important;
                flex-direction: row !important;
                justify-content: space-between !important;
            }
        }
        @media (max-width: 480px) {
            .wallet-header h1 {
                font-size: 1.5rem !important;
            }
            .balance-card {
                padding: 1.5rem !important;
            }
            .section-heading {
                font-size: 1.5rem !important;
            }
            .btn {
                padding: 0.75rem !important;
                font-size: 0.875rem !important;
            }
            .transaction-card {
                padding: 1rem !important;
            }
            .badge {
                padding: 0.5rem 0.75rem !important;
                font-size: 0.65rem !important;
            }
        }
    </style>

    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem;" class="wallet-header">
            <div>
                <h1 class="text-4xl sm:text-6xl font-black uppercase tracking-tighter">Wallet</h1>
                <p class="text-gray-600 mt-2 text-sm">Manage your coins and view transaction history</p>
            </div>
        </div>
    </x-slot>

    <div style="max-width: 100%; margin: 0 auto; display: flex; flex-direction: column; gap: 2rem;" class="wallet-container">

        <!-- Coins Balance Card -->
        <div class="section bg-bauhaus-red text-white">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 2rem;" class="section-container balance-card">
                <div>
                    <p class="uppercase-label text-sm mb-2">Current Balance</p>
                    <h2 class="text-5xl sm:text-7xl font-black tracking-tighter mb-2">{{ number_format(auth()->user()->coins, 0) }}</h2>
                    <p class="text-white/80 text-lg">Coins Available</p>
                </div>
            </div>
        </div>

        <!-- Top-up Section -->
        <x-card-bauhaus>
            <h3 class="text-3xl font-black uppercase tracking-tight mb-6 pb-4 border-b-4 border-bauhaus-black section-heading">Add Coins via Khalti</h3>
            
            {{-- Display success message if any --}}
            @if ($message = Session::get('success'))
                <div style="background-color: #4CAF50; color: white; padding: 1rem; border: 2px solid #121212; margin-bottom: 1.5rem; border-radius: 4px;">
                    <p style="margin: 0; font-weight: bold;">✓ {{ $message }}</p>
                </div>
            @endif

            {{-- Display error messages if any --}}
            @if ($errors->any())
                <div style="background-color: #D02020; color: white; padding: 1rem; border: 2px solid #121212; margin-bottom: 1.5rem; border-radius: 4px;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li style="font-weight: bold;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form id="wallet-topup-form" action="{{ route('wallet.topup') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="amount" class="block uppercase-label text-sm mb-3">
                        Amount (Coins)
                    </label>
                    <x-input-bauhaus 
                        type="number" 
                        id="amount" 
                        name="amount" 
                        min="1" 
                        max="999999.99" 
                        step="1" 
                        value="{{ old('amount') }}"
                        placeholder="Enter amount"
                        required
                    />
                    @error('amount')
                        <p class="text-bauhaus-red font-bold text-sm mt-2">{{ $message }}</p>
                    @enderror
                    @error('payment')
                        <p class="text-bauhaus-red font-bold text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-600 text-sm mt-2">Powered by <strong>Khalti Payment Gateway</strong></p>
                </div>

                <button 
                    type="submit"
                    id="topup-button"
                    class="btn btn-primary w-full"
                >
                    Proceed to Khalti Payment
                </button>
            </form>
        </x-card-bauhaus>

        <!-- Redeem Coins Section -->
        <x-card-bauhaus>
            <h3 class="text-3xl font-black uppercase tracking-tight mb-6 pb-4 border-b-4 border-bauhaus-black section-heading">Redeem Coins</h3>
            
            <p style="font-size: 0.95rem; color: #666; margin-bottom: 1.5rem;">
                Submit your bank account or payment proof to redeem your coins. Our admin team will review your request and process it.
            </p>

            <!-- Redeem Form Modal Button -->
            <button 
                id="redeem-button"
                type="button"
                class="btn btn-secondary"
                onclick="document.getElementById('redeem-modal').style.display='flex'"
                style="background-color: #1040C0; color: white; border: 4px solid #121212; padding: 1rem 2rem; text-transform: uppercase; font-weight: 900; cursor: pointer; transition: all 0.2s ease; width: 100%;"
                onmouseover="this.style.transform='translate(-3px, -3px)'; this.style.boxShadow='6px 6px 0px rgba(16, 64, 192, 0.2)';"
                onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';"
            >
                Submit Redeem Request
            </button>

            <!-- Redeem Modal -->
            <div id="redeem-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); z-index: 1000; align-items: center; justify-content: center;">
                <div style="background: white; border: 4px solid #121212; padding: 2rem; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3); border-radius: 4px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h4 style="font-size: 1.5rem; font-weight: 900; color: #121212; text-transform: uppercase;">Redeem Coins</h4>
                        <button 
                            type="button" 
                            onclick="document.getElementById('redeem-modal').style.display='none'"
                            style="background: none; border: none; font-size: 2rem; cursor: pointer; color: #121212; padding: 0; margin: 0;">
                            ×
                        </button>
                    </div>

                    <form action="{{ route('wallet.redeem') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">
                                Amount (Coins)
                            </label>
                            <input 
                                type="number" 
                                name="coins_amount" 
                                min="1" 
                                max="{{ auth()->user()->coins }}"
                                step="1" 
                                placeholder="Enter coins to redeem"
                                style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500;"
                                required 
                            />
                            <p style="font-size: 0.8rem; color: #666; margin-top: 0.5rem;">Available: {{ auth()->user()->coins }} coins</p>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">
                                Proof Image (Scanner/Bank Account)
                            </label>
                            <input 
                                type="file" 
                                name="proof_image" 
                                accept="image/*" 
                                style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500; display: block;"
                                required 
                            />
                            <p style="font-size: 0.8rem; color: #666; margin-top: 0.5rem;">JPG, PNG, or GIF. Max 5MB.</p>
                        </div>

                        <div style="display: flex; gap: 1rem;">
                            <button 
                                type="button"
                                onclick="document.getElementById('redeem-modal').style.display='none'"
                                style="flex: 1; background-color: #F0F0F0; color: #121212; border: 3px solid #121212; font-weight: 900; padding: 0.75rem 1.5rem; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 0.5px; cursor: pointer; transition: all 0.2s ease; font-family: 'Outfit', sans-serif;"
                                onmouseover="this.style.backgroundColor='#E0E0E0';"
                                onmouseout="this.style.backgroundColor='#F0F0F0';"
                            >
                                Cancel
                            </button>

                            <button 
                                type="submit"
                                style="flex: 1; background-color: #1040C0; color: white; border: 4px solid #121212; font-weight: 900; padding: 0.75rem 1.5rem; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 0.5px; cursor: pointer; transition: all 0.2s ease; font-family: 'Outfit', sans-serif;"
                                onmouseover="this.style.transform='translate(-2px, -2px)'; this.style.boxShadow='4px 4px 0px rgba(16, 64, 192, 0.2)';"
                                onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';"
                            >
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Close modal when clicking outside -->
            <script>
                document.getElementById('redeem-modal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.style.display = 'none';
                    }
                });
            </script>
        </x-card-bauhaus>

        <!-- Transaction History -->
        <x-card-bauhaus>
            <h3 class="text-3xl font-black uppercase tracking-tight mb-6 pb-4 border-b-4 border-bauhaus-black section-heading">Transaction History</h3>

            @if($transactions->count() > 0)
                <div class="space-y-3">
                    @foreach($transactions as $transaction)
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; border: 2px solid #121212; padding: 1rem; gap: 1rem; flex-wrap: wrap;" class="border-2 border-bauhaus-black hover:bg-canvas/50 transition-colors transaction-card">
                            <div style="display: flex; align-items: center; gap: 1rem; flex: 1;" class="transaction-left">
                                <!-- Type Badge -->
                                <div style="flex-shrink: 0;">
                                    <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.5rem 0.75rem; font-weight: 900; font-size: 0.875rem; border: 2px solid #121212;
                                        @if($transaction->type === 'credit')
                                            background-color: #FFC107; color: #121212;
                                        @else
                                            background-color: #D02020; color: white;
                                        @endif
                                    " class="badge">
                                        @if($transaction->type === 'credit')
                                            ↓ Credit
                                        @else
                                            ↑ Debit
                                        @endif
                                    </span>
                                </div>

                                <!-- Transaction Details -->
                                <div>
                                    <p style="font-weight: 900; color: #121212; margin-bottom: 0.25rem;">
                                        @if($transaction->reason === 'topup')
                                            Coin Top-up
                                        @elseif($transaction->reason === 'purchase')
                                            Purchase Payment
                                        @else
                                            {{ ucfirst($transaction->reason) }}
                                        @endif
                                    </p>
                                    <p style="font-size: 0.75rem; color: #666; margin-top: 0.25rem;">
                                        {{ $transaction->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Amount and Status -->
                            <div style="display: flex; align-items: center; gap: 1rem; min-width: fit-content;" class="transaction-right">
                                <!-- Amount -->
                                <div style="text-align: right;">
                                    <span style="font-weight: 900; font-size: 1.125rem;
                                        @if($transaction->type === 'credit')
                                            color: #FFC107;
                                        @else
                                            color: #D02020;
                                        @endif
                                    ">
                                        @if($transaction->type === 'credit')
                                            +{{ number_format($transaction->amount, 0) }}
                                        @else
                                            -{{ number_format($transaction->amount, 0) }}
                                        @endif
                                    </span>
                                </div>

                                <!-- Status Badge -->
                                <div style="flex-shrink: 0;">
                                    <span style="display: inline-flex; align-items: center; padding: 0.5rem 0.75rem; font-weight: 700; font-size: 0.875rem; border: 2px solid #121212;
                                        @if($transaction->status === 'success')
                                            background-color: #FFC107; color: #121212;
                                        @elseif($transaction->status === 'pending')
                                            background-color: #1040C0; color: white;
                                        @else
                                            background-color: #D02020; color: white;
                                        @endif
                                    " class="badge">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 border-t-2 border-bauhaus-black pt-4">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="py-12 text-center">
                    <p class="text-2xl font-black text-bauhaus-black mb-2">No Transactions Yet</p>
                    <p class="text-gray-600">Your transaction history will appear here</p>
                </div>
            @endif
        </x-card-bauhaus>
    </div>
    
    <script>
        (function() {
            const form = document.getElementById('wallet-topup-form');
            const button = document.getElementById('topup-button');
            
            if (!form || !button) {
                return;
            }

            form.addEventListener('submit', function(e) {
                const amountInput = document.getElementById('amount');
                const amount = parseFloat(amountInput.value);

                // Validation
                if (isNaN(amount) || amount <= 0) {
                    e.preventDefault();
                    alert('Please enter a valid amount greater than 0.');
                    return;
                }

                if (amount > 999999.99) {
                    e.preventDefault();
                    alert('Amount cannot exceed 999999.99 coins.');
                    return;
                }

                // Disable button and show loading state
                button.disabled = true;
                button.innerHTML = 'Processing... Redirecting to Khalti...';
                button.style.opacity = '0.6';
                button.style.cursor = 'not-allowed';
            });
        })();
    </script>
</x-app-layout>
