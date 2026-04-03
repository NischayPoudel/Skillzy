<x-app-layout>
    <style>
        /* Profile Header Section */
        .profile-header {
            background: white;
            border: 2px solid #121212;
            border-radius: 8px;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            display: flex;
            gap: 3rem;
            align-items: flex-start;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .profile-header-left {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            flex: 0 0 auto;
        }

        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 4px solid #D02020;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-image i {
            font-size: 4rem;
            color: #D02020;
        }

        .profile-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            width: 100%;
            flex-wrap: wrap;
        }

        .profile-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid #121212;
            background: white;
            color: #121212;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
        }

        .profile-btn:hover {
            background: #121212;
            color: white;
        }

        .profile-btn.primary {
            background: #D02020;
            color: white;
            border-color: #D02020;
        }

        .profile-btn.primary:hover {
            background: #a01a1a;
            border-color: #a01a1a;
        }

        .profile-header-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .profile-info-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .profile-info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .profile-info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #666;
            letter-spacing: 0.5px;
        }

        .profile-info-value {
            font-size: 1.25rem;
            font-weight: 600;
            color: #121212;
        }

        .profile-bio {
            font-size: 1rem;
            color: #333;
            line-height: 1.6;
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 4px;
            border-left: 4px solid #D02020;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .stat-item {
            background: #f9f9f9;
            padding: 1rem;
            border-radius: 4px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: #D02020;
        }

        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #666;
            margin-top: 0.5rem;
            font-weight: 600;
        }

        /* Skills Section */
        .skills-section {
            margin-top: 2rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #121212;
            margin: 2rem 0 1.5rem 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .section-title i {
            color: #D02020;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .skill-card {
            background: white;
            border: 2px solid #121212;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
        }

        .skill-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
            border-color: #D02020;
        }

        .skill-card-header {
            background: linear-gradient(135deg, #D02020 0%, #a01a1a 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .skill-icon {
            font-size: 3rem;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }

        .skill-name {
            font-size: 1.25rem;
            font-weight: 700;
            text-align: center;
        }

        .skill-card-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .skill-description {
            font-size: 0.875rem;
            color: #555;
            line-height: 1.5;
            flex: 1;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: white;
            border: 2px dashed #ccc;
            border-radius: 8px;
            color: #666;
        }

        .empty-state i {
            font-size: 3rem;
            color: #D02020;
            margin-bottom: 1rem;
            display: block;
        }

        .empty-state-text {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .empty-state-action {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #D02020;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .empty-state-action:hover {
            background: #a01a1a;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #D02020;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            gap: 1rem;
        }

        .back-link i {
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                align-items: center;
                padding: 1.5rem;
                gap: 1.5rem;
            }

            .profile-header-right {
                width: 100%;
            }

            .profile-image {
                width: 140px;
                height: 140px;
            }

            .profile-image i {
                font-size: 3rem;
            }

            .skills-grid {
                grid-template-columns: 1fr;
            }

            .profile-actions {
                flex-wrap: wrap;
            }

            .section-title {
                font-size: 1.25rem;
            }
        }
    </style>

    <a href="{{ route('dashboard') }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Back to Dashboard
    </a>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-header-left">
            <div class="profile-image">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}">
                @else
                    <i class="fas fa-user"></i>
                @endif
            </div>

            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="profile-btn primary">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </a>
            </div>
        </div>

        <div class="profile-header-right">
            <div class="profile-info-section">
                <div class="profile-info-item">
                    <span class="profile-info-label">Full Name</span>
                    <span class="profile-info-value">{{ $user->name }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label">Username</span>
                    <span class="profile-info-value">{{ $user->username }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label">Email</span>
                    <span class="profile-info-value">{{ $user->email }}</span>
                </div>
                @if($user->phone_number)
                <div class="profile-info-item">
                    <span class="profile-info-label">Phone</span>
                    <span class="profile-info-value">{{ $user->phone_number }}</span>
                </div>
                @endif
            </div>

            @if($user->bio)
            <div class="profile-bio">
                <strong>About:</strong> {{ $user->bio }}
            </div>
            @endif

            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $user->coins }}</div>
                    <div class="stat-label">Coins</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $skills->count() }}</div>
                    <div class="stat-label">Skills Listed</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Skills Section -->
    <div class="skills-section">
        <h2 class="section-title">
            <i class="fas fa-star"></i>
            My Skills
        </h2>

        @if($skills->count() > 0)
            <div class="skills-grid">
                @foreach($skills as $skill)
                <div class="skill-card">
                    <div class="skill-card-header">
                        <div class="skill-icon">
                            <i class="fas {{ $skill->icon ?? 'fa-star' }}"></i>
                        </div>
                        <h3 class="skill-name">{{ $skill->name }}</h3>
                    </div>
                    <div class="skill-card-body">
                        <p class="skill-description">{{ $skill->description ?? 'No description provided.' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <div class="empty-state-text">
                    No skills listed yet.
                </div>
                <a href="{{ route('user.listings.create') }}" class="empty-state-action">
                    <i class="fas fa-plus"></i>
                    Create First Listing
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
