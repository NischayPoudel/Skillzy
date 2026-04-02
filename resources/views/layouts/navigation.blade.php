<nav style="border-bottom: 4px solid #121212; background-color: white; display: block; width: 100%; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);">
    <style>
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 1rem !important;
                height: 60px !important;
            }
            .nav-logo {
                gap: 0.5rem !important;
            }
            .nav-logo span {
                font-size: 1rem !important;
            }
            .nav-logo div {
                width: 32px !important;
                height: 32px !important;
                font-size: 0.875rem !important;
            }
            .nav-links {
                display: none !important;
            }
            .search-form {
                width: 100% !important;
                max-width: 180px !important;
                height: 36px !important;
                gap: 0 !important;
                order: 3 !important;
                margin: 0 0.5rem !important;
            }
            .search-form input {
                width: 100px !important;
                height: 36px !important;
                font-size: 0.7rem !important;
            }
            .search-form button {
                height: 36px !important;
                padding: 0 0.75rem !important;
                font-size: 0.65rem !important;
                line-height: 36px !important;
            }
            .user-menu {
                gap: 0.75rem !important;
            }
            .user-info {
                display: none !important;
            }
            .menu-btn {
                display: flex !important;
                width: 36px !important;
                height: 36px !important;
                border: 2px solid #121212 !important;
                background: white !important;
                cursor: pointer !important;
                flex-direction: column !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 4px !important;
            }
            .menu-btn span {
                width: 20px !important;
                height: 2px !important;
                background: #121212 !important;
            }
            .mobile-menu {
                display: flex !important;
                flex-direction: column !important;
                position: absolute !important;
                top: 60px !important;
                left: 0 !important;
                right: 0 !important;
                background: white !important;
                border-bottom: 4px solid #121212 !important;
                padding: 1rem !important;
                gap: 0.5rem !important;
                z-index: 1000 !important;
            }
            .mobile-menu a {
                padding: 0.75rem !important;
                text-decoration: none !important;
                border: 2px solid #121212 !important;
                text-align: center !important;
                font-size: 0.75rem !important;
                font-weight: 600 !important;
                text-transform: uppercase !important;
            }
        }
        @media (max-width: 600px) {
            .nav-container {
                height: 50px !important;
            }
            .search-form {
                max-width: 150px !important;
                height: 32px !important;
            }
            .search-form input {
                width: 80px !important;
                height: 32px !important;
            }
            .search-form button {
                height: 32px !important;
                line-height: 32px !important;
                padding: 0 0.5rem !important;
            }
            .logout-btn, .auth-btns {
                display: none !important;
            }
        }
        
        /* Profile Dropdown Styles */
        .profile-dropdown {
            position: relative;
        }
        
        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        .profile-trigger:hover {
            background-color: #f5f5f5;
        }
        
        .profile-pic-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #D02020;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .profile-pic-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-pic-circle i {
            font-size: 1.5rem;
            color: #D02020;
        }
        
        .profile-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 2px solid #121212;
            border-radius: 4px;
            min-width: 180px;
            margin-top: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            display: none;
        }
        
        .profile-dropdown-menu.active {
            display: flex;
            flex-direction: column;
        }
        
        .profile-dropdown-menu a,
        .profile-dropdown-menu button {
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: #121212;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
        }
        
        .profile-dropdown-menu a:hover,
        .profile-dropdown-menu button:hover {
            background-color: #f5f5f5;
        }
        
        .profile-dropdown-menu a:not(:last-child),
        .profile-dropdown-menu button:not(:last-child) {
            border-bottom: 1px solid #e0e0e0;
        }
        
        .profile-dropdown-menu form {
            width: 100%;
        }
        
        .profile-dropdown-menu form button {
            width: 100%;
            color: #D02020;
            font-weight: 600;
            border-top: 2px solid #f0f0f0;
        }
    </style>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; height: 70px; gap: 2rem;" class="nav-container">
        <!-- Logo & Brand -->
        <div style="display: flex; align-items: center; gap: 0.75rem; flex: 0 0 auto;" class="nav-logo">
            <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit;">
                <div style="width: 40px; height: 40px; background-color: #D02020; border-radius: 4px; border: 2px solid #121212; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 1rem;">S</div>
                <span style="font-weight: 900; font-size: 1.25rem; text-transform: uppercase; letter-spacing: 1px;">Skillzy</span>
            </a>
        </div>

        <!-- Desktop Navigation Links -->
        <div style="display: flex; align-items: center; gap: 1.5rem; flex: 0 0 auto;" class="nav-links">
            <a href="{{ route('dashboard') }}" 
               style="text-transform: uppercase; font-size: 0.75rem; text-decoration: none; color: {{ request()->routeIs('dashboard') ? '#D02020' : '#1b1b18' }}; font-weight: 600; letter-spacing: 0.5px; transition: color 0.3s ease; padding-bottom: 2px; border-bottom: 2px solid {{ request()->routeIs('dashboard') ? '#D02020' : 'transparent' }};">
                Home
            </a>
            
            <a href="{{ route('listings.index') }}" 
               style="text-transform: uppercase; font-size: 0.75rem; text-decoration: none; color: {{ request()->routeIs('listings.*') ? '#D02020' : '#1b1b18' }}; font-weight: 600; letter-spacing: 0.5px; transition: color 0.3s ease; padding-bottom: 2px; border-bottom: 2px solid {{ request()->routeIs('listings.*') ? '#D02020' : 'transparent' }};">
                Browse Skills
            </a>
            
            <a href="{{ route('purchases.index') }}" 
               style="text-transform: uppercase; font-size: 0.75rem; text-decoration: none; color: {{ request()->routeIs('purchases.*') ? '#D02020' : '#1b1b18' }}; font-weight: 600; letter-spacing: 0.5px; transition: color 0.3s ease; padding-bottom: 2px; border-bottom: 2px solid {{ request()->routeIs('purchases.*') ? '#D02020' : 'transparent' }};">
                Purchases
            </a>
            <a href="{{ route('wallet.show') }}" 
               style="text-transform: uppercase; font-size: 0.75rem; text-decoration: none; color: {{ request()->routeIs('wallet.*') ? '#D02020' : '#1b1b18' }}; font-weight: 600; letter-spacing: 0.5px; transition: color 0.3s ease; padding-bottom: 2px; border-bottom: 2px solid {{ request()->routeIs('wallet.*') ? '#D02020' : 'transparent' }};">
                Wallet
            </a>
            <a href="{{ route('about.show') }}" 
               style="text-transform: uppercase; font-size: 0.75rem; text-decoration: none; color: {{ request()->routeIs('about.*') ? '#D02020' : '#1b1b18' }}; font-weight: 600; letter-spacing: 0.5px; transition: color 0.3s ease; padding-bottom: 2px; border-bottom: 2px solid {{ request()->routeIs('about.*') ? '#D02020' : 'transparent' }};">
                About
            </a>
            <!-- Notification Icon -->
            <a href="#" 
               style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; text-decoration: none; transition: all 0.3s ease; position: relative;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #1b1b18;">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    <circle cx="18" cy="8" r="3" fill="#D02020"></circle>
                </svg>
            </a>

            <!-- Message Icon -->
            @auth
            <a href="{{ route('messages.index') }}" 
               style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; text-decoration: none; transition: all 0.3s ease; position: relative;" title="Messages">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #1b1b18;">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                @php
                    $unreadCount = Auth::user()->receivedMessages()->where('is_read', 0)->count();
                @endphp
                @if($unreadCount > 0)
                    <span style="position: absolute; top: -2px; right: -2px; background: #D02020; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700; border: 2px solid white;">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </a>
            @endauth

            @auth
            <a href="{{ route('user.listings.create') }}" 
               style="text-transform: uppercase; font-size: 0.75rem; text-decoration: none; padding: 0.6rem 1.2rem; border: 2px solid #D02020; background-color: #D02020; color: white; font-weight: 700; letter-spacing: 0.5px; transition: all 0.3s ease; border-radius: 4px;">
                + Create Listing
            </a>
            @endauth
        </div>

        <!-- Search Bar - Fixed Unit -->
        <form action="{{ route('listings.search') }}" method="GET" style="display: flex; align-items: stretch; gap: 0; flex: 0 0 auto; height: 42px;" class="search-form">
            <input type="text" name="q" placeholder="Search skills..." style="padding: 0 1rem; border: 2px solid #121212; border-right: none; font-size: 0.75rem; font-weight: 600; width: 240px; box-sizing: border-box; font-family: inherit; height: 42px; display: flex; align-items: center;" required>
            <button type="submit" style="padding: 0 1rem; border: 2px solid #121212; background-color: #D02020; color: white; font-weight: 700; cursor: pointer; text-transform: uppercase; font-size: 0.75rem; white-space: nowrap; box-sizing: border-box; height: 42px; line-height: 42px;">Search</button>
        </form>

        <!-- User Menu / Auth Actions -->
        <div style="display: flex; align-items: center; gap: 1.5rem; flex: 0 0 auto;" class="user-menu">
            @auth
                <!-- Profile Dropdown -->
                <div class="profile-dropdown" id="profile-dropdown">
                    <div class="profile-trigger" id="profile-trigger">
                        <div style="display: flex; align-items: center; gap: 0.75rem; text-align: right;">
                            <div>
                                <div style="font-size: 0.875rem; font-weight: 700; color: #121212;">{{ Auth::user()->name }}</div>
                                <div style="font-size: 0.75rem; color: #666; margin-top: 2px; display: flex; align-items: center; justify-content: flex-end; gap: 0.25rem;">
                                    <span style="color: #D02020; font-weight: 700;">{{ number_format(Auth::user()->coins, 0) }} Coins</span>
                                </div>
                            </div>
                        </div>
                        <div class="profile-pic-circle">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile">
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                    </div>
                    
                    <div class="profile-dropdown-menu" id="profile-menu">
                        <a href="{{ route('profile.edit') }}">
                            <i class="fas fa-edit"></i>
                            Edit Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            @else
                <div class="auth-btns" style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('login') }}" style="padding: 0.6rem 1.2rem; border: 2px solid #1040C0; background-color: transparent; color: #1040C0; font-weight: 700; text-decoration: none; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; transition: all 0.3s ease; border-radius: 4px;">
                        Login
                    </a>
                    <a href="{{ route('register') }}" style="padding: 0.6rem 1.2rem; border: 2px solid #D02020; background-color: #D02020; color: white; font-weight: 700; text-decoration: none; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; transition: all 0.3s ease; border-radius: 4px;">
                        Sign Up
                    </a>
                </div>
            @endauth

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" style="display: none;" class="menu-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" style="display: none;" class="mobile-menu">
        <a href="{{ route('dashboard') }}" style="color: {{ request()->routeIs('dashboard') ? '#D02020' : '#1b1b18' }};">Home</a>
        <a href="{{ route('listings.index') }}" style="color: {{ request()->routeIs('listings.*') ? '#D02020' : '#1b1b18' }};">Browse Skills</a>
        <a href="{{ route('purchases.index') }}" style="color: {{ request()->routeIs('purchases.*') ? '#D02020' : '#1b1b18' }};">Purchases</a>
        <a href="{{ route('wallet.show') }}" style="color: {{ request()->routeIs('wallet.*') ? '#D02020' : '#1b1b18' }};">Wallet</a>
        <a href="{{ route('about.show') }}" style="color: {{ request()->routeIs('about.*') ? '#D02020' : '#1b1b18' }};">About</a>
        <a href="#" style="display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #1b1b18;">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                <circle cx="18" cy="8" r="3" fill="#D02020"></circle>
            </svg>
        </a>
        @auth
            <a href="{{ route('user.listings.create') }}" style="background-color: #D02020; color: white; font-weight: 700; text-align: center;">+ Create Listing</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width: 100%; padding: 0.75rem; border: 2px solid #D02020; background-color: #D02020; color: white; font-weight: 700; cursor: pointer; text-transform: uppercase; font-size: 0.75rem;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" style="color: #1040C0;">Login</a>
            <a href="{{ route('register') }}" style="background-color: #D02020; color: white;">Sign Up</a>
        @endauth
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            
            if (btn && menu) {
                btn.addEventListener('click', function() {
                    menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
                });
            }
            
            // Profile Dropdown Toggle
            const profileTrigger = document.getElementById('profile-trigger');
            const profileMenu = document.getElementById('profile-menu');
            
            if (profileTrigger && profileMenu) {
                profileTrigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileMenu.classList.toggle('active');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.profile-dropdown')) {
                        profileMenu.classList.remove('active');
                    }
                });
                
                // Close dropdown when clicking on a link
                profileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function() {
                        profileMenu.classList.remove('active');
                    });
                });
            }
        });
    </script>
</nav>
