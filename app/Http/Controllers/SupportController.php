<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SupportController extends Controller
{
    public function show(): View
    {
        $faqs = [
            [
                'question' => 'How do I create a listing?',
                'answer' => 'To create a listing, navigate to your dashboard and click on "Create New Listing". Select a skill, set your price, choose your experience level, and submit. Your listing will be visible to other users immediately.',
            ],
            [
                'question' => 'What are Skillzy Coins?',
                'answer' => 'Skillzy Coins are the currency of our platform. You earn coins by providing services to others, and you can spend coins to purchase services from other members. Coins can be purchased at any time through the wallet page.',
            ],
            [
                'question' => 'How do I purchase a skill?',
                'answer' => 'Browse available skills using the search bar, select one that interests you, and click "Request Service". Once the seller accepts your request, you can communicate through the messages section. Complete payment when ready.',
            ],
            [
                'question' => 'Is my payment information secure?',
                'answer' => 'Yes! Coins are added directly and securely to your wallet. Your account information is encrypted and protected with industry-standard security measures.',
            ],
            [
                'question' => 'How long does a purchase take?',
                'answer' => 'The duration depends on the service. You can communicate with the seller about timeline and expectations through the messages section of your purchase.',
            ],
            [
                'question' => 'What if I\'m not satisfied with the service?',
                'answer' => 'You can leave a review and rating after the purchase is completed. We recommend communicating any concerns with the seller directly through the messaging feature.',
            ],
        ];

        $contactMethods = [
            [
                'icon' => '✉',
                'title' => 'Email Support',
                'description' => 'Get help via email',
                'contact' => 'support@skillzy.com',
                'response_time' => '24-48 hours',
            ],
            [
                'icon' => '◉',
                'title' => 'Live Chat',
                'description' => 'Chat with our team',
                'contact' => 'Available 9 AM - 6 PM (Weekdays)',
                'response_time' => 'Instant',
            ],
            [
                'icon' => '☎',
                'title' => 'Phone Support',
                'description' => 'Call us directly',
                'contact' => '+977-1-5234567',
                'response_time' => '5-10 minutes',
            ],
            [
                'icon' => 'f',
                'title' => 'Social Media',
                'description' => 'Reach us on social media',
                'contact' => '@skillzyofficial',
                'response_time' => '2-4 hours',
            ],
        ];

        return view('support.show', [
            'faqs' => $faqs,
            'contactMethods' => $contactMethods,
        ]);
    }
}
