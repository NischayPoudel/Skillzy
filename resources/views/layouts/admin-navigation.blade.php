<div class="admin-sidebar" style="width: 260px; background-color: #1040C0; color: white; display: flex; flex-direction: column; padding: 2rem 0; box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1); position: fixed; height: 100vh; overflow-y: auto; left: 0; top: 0; z-index: 100;">
    <div class="admin-sidebar-header" style="padding: 0 1.5rem 2rem; border-bottom: 1px solid rgba(255, 255, 255, 0.2);">
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold" style="color: white; font-weight: 700; text-decoration: none; display: block; font-size: 1.5rem;">
            Skillzy
        </a>
    </div>
    <nav class="admin-sidebar-nav" style="flex: 1; padding: 1rem 0; display: flex; flex-direction: column;">
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.5rem; color: rgba(255, 255, 255, 0.9); text-decoration: none; font-weight: 500; border-left: 3px solid {{ request()->routeIs('admin.dashboard') ? 'white' : 'transparent' }}; background-color: {{ request()->routeIs('admin.dashboard') ? 'rgba(255, 255, 255, 0.15)' : 'transparent' }}; transition: all 0.2s;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.5rem; color: rgba(255, 255, 255, 0.9); text-decoration: none; font-weight: 500; border-left: 3px solid {{ request()->routeIs('admin.users.*') ? 'white' : 'transparent' }}; background-color: {{ request()->routeIs('admin.users.*') ? 'rgba(255, 255, 255, 0.15)' : 'transparent' }}; transition: all 0.2s;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A6.995 6.995 0 0012 12.75a6.995 6.995 0 00-3-5.197M15 21a9 9 0 00-9-9"></path></svg>
            <span>Users</span>
        </a>
        <a href="{{ route('admin.skills.index') }}" class="admin-nav-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.5rem; color: rgba(255, 255, 255, 0.9); text-decoration: none; font-weight: 500; border-left: 3px solid {{ request()->routeIs('admin.skills.*') ? 'white' : 'transparent' }}; background-color: {{ request()->routeIs('admin.skills.*') ? 'rgba(255, 255, 255, 0.15)' : 'transparent' }}; transition: all 0.2s;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707.707"></path></svg>
            <span>Skills</span>
        </a>
        <a href="{{ route('admin.coins.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coins.*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.5rem; color: rgba(255, 255, 255, 0.9); text-decoration: none; font-weight: 500; border-left: 3px solid {{ request()->routeIs('admin.coins.*') ? 'white' : 'transparent' }}; background-color: {{ request()->routeIs('admin.coins.*') ? 'rgba(255, 255, 255, 0.15)' : 'transparent' }}; transition: all 0.2s;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Coins</span>
        </a>
        <a href="{{ route('admin.purchases.index') }}" class="admin-nav-link {{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.5rem; color: rgba(255, 255, 255, 0.9); text-decoration: none; font-weight: 500; border-left: 3px solid {{ request()->routeIs('admin.purchases.*') ? 'white' : 'transparent' }}; background-color: {{ request()->routeIs('admin.purchases.*') ? 'rgba(255, 255, 255, 0.15)' : 'transparent' }}; transition: all 0.2s;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span>Purchases</span>
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="admin-nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.5rem; color: rgba(255, 255, 255, 0.9); text-decoration: none; font-weight: 500; border-left: 3px solid {{ request()->routeIs('admin.reviews.*') ? 'white' : 'transparent' }}; background-color: {{ request()->routeIs('admin.reviews.*') ? 'rgba(255, 255, 255, 0.15)' : 'transparent' }}; transition: all 0.2s;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            <span>Reviews</span>
        </a>
    </nav>
    <div class="admin-sidebar-footer" style="padding: 1rem 0; border-top: 1px solid rgba(255, 255, 255, 0.2);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="admin-nav-link" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.5rem; color: rgba(255, 255, 255, 0.9); text-decoration: none; font-weight: 500; border-left: 3px solid transparent; transition: all 0.2s;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </a>
        </form>
    </div>
</div>
