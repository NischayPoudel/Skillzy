<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AboutController extends Controller
{
    public function show(): View
    {
        $features = [
            [
                'icon' => '↔',
                'title' => 'Peer-to-Peer',
                'description' => 'Direct connections between skill providers and seekers without intermediaries.',
            ],
            [
                'icon' => '$',
                'title' => 'Transparent Pricing',
                'description' => 'Fair pricing with our coin-based system. No hidden fees or surprises.',
            ],
            [
                'icon' => '#',
                'title' => 'Secure',
                'description' => 'Your payments and data are protected with industry-leading security.',
            ],
            [
                'icon' => '★',
                'title' => 'Rated & Reviewed',
                'description' => 'Community-driven ratings and reviews ensure quality and trust.',
            ],
            [
                'icon' => '◉',
                'title' => 'Global Community',
                'description' => 'Connect with skill experts from around the world.',
            ],
            [
                'icon' => '≡',
                'title' => 'Always Available',
                'description' => 'Access the platform anytime, anywhere on any device.',
            ],
        ];

        $stats = [
            ['label' => 'Active Users', 'value' => '5,000+'],
            ['label' => 'Skills Available', 'value' => '500+'],
            ['label' => 'Completed Services', 'value' => '10,000+'],
            ['label' => 'Countries', 'value' => '25+'],
        ];

        $teamMembers = [
            [
                'name' => 'Rajesh Kumar',
                'role' => 'Founder & CEO',
                'bio' => 'Visionary leader with 10+ years in tech entrepreneurship.',
                'icon' => 'CEO',
            ],
            [
                'name' => 'Priya Singh',
                'role' => 'CTO',
                'bio' => 'Full-stack developer passionate about building scalable platforms.',
                'icon' => 'CTO',
            ],
            [
                'name' => 'Amit Patel',
                'role' => 'Product Manager',
                'bio' => 'User-focused product strategist with experience at major startups.',
                'icon' => 'PM',
            ],
            [
                'name' => 'Neha Sharma',
                'role' => 'Community Manager',
                'bio' => 'Passionate about building engaged and supportive communities.',
                'icon' => 'CM',
            ],
        ];

        return view('about.show', [
            'features' => $features,
            'stats' => $stats,
            'teamMembers' => $teamMembers,
        ]);
    }
}
