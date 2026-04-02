<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use App\Models\UserSkill;
use App\Models\Purchase;
use App\Models\CoinTransaction;
use App\Models\Review;
use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'coins' => 10000,
            'profile_image' => null,
            'bio' => 'Platform administrator',
        ]);

        // Create staff users
        $staff1 = User::create([
            'name' => 'Staff Member',
            'username' => 'staff',
            'email' => 'staff@example.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'coins' => 5000,
            'profile_image' => null,
            'bio' => 'Platform staff member',
        ]);

        // Create regular users
        $john = User::create([
            'name' => 'John Developer',
            'username' => 'johndeveloper',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'coins' => 1000,
            'profile_image' => null,
            'bio' => 'Experienced PHP and Laravel developer',
        ]);

        $jane = User::create([
            'name' => 'Jane Designer',
            'username' => 'janedesigner',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'coins' => 800,
            'profile_image' => null,
            'bio' => 'UI/UX designer with 5+ years experience',
        ]);

        $mike = User::create([
            'name' => 'Mike Consultant',
            'username' => 'mikeconsultant',
            'email' => 'mike@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'coins' => 1500,
            'profile_image' => null,
            'bio' => 'Business consultant and strategist',
        ]);

        $sarah = User::create([
            'name' => 'Sarah Marketer',
            'username' => 'sarahmarketer',
            'email' => 'sarah@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'coins' => 600,
            'profile_image' => null,
            'bio' => 'Digital marketing specialist',
        ]);

        // Create skills (by admin/staff)
        $phpSkill = Skill::create([
            'name' => 'PHP Development',
            'description' => 'Expert-level PHP development including Laravel, WordPress, and custom solutions',
            'icon' => 'P',
            'created_by' => $admin->id,
        ]);

        $jsSkill = Skill::create([
            'name' => 'JavaScript Development',
            'description' => 'Full-stack JavaScript development with React, Vue, and Node.js',
            'icon' => 'J',
            'created_by' => $admin->id,
        ]);

        $uiSkill = Skill::create([
            'name' => 'UI/UX Design',
            'description' => 'Professional UI/UX design and prototyping services',
            'icon' => 'U',
            'created_by' => $staff1->id,
        ]);

        $consultSkill = Skill::create([
            'name' => 'Business Consulting',
            'description' => 'Strategic business consultation and planning',
            'icon' => 'B',
            'created_by' => $admin->id,
        ]);

        $marketingSkill = Skill::create([
            'name' => 'Digital Marketing',
            'description' => 'SEO, SEM, social media marketing, and content strategy',
            'icon' => 'D',
            'created_by' => $admin->id,
        ]);

        $apiSkill = Skill::create([
            'name' => 'API Development',
            'description' => 'REST API and GraphQL development services',
            'icon' => 'A',
            'created_by' => $admin->id,
        ]);

        // Create user skills (listings)
        $listing1 = UserSkill::create([
            'user_id' => $john->id,
            'skill_id' => $phpSkill->id,
            'price' => 150,
            'experience_level' => 'expert',
            'status' => 'active',
        ]);

        $listing2 = UserSkill::create([
            'user_id' => $john->id,
            'skill_id' => $apiSkill->id,
            'price' => 180,
            'experience_level' => 'expert',
            'status' => 'active',
        ]);

        $listing3 = UserSkill::create([
            'user_id' => $jane->id,
            'skill_id' => $uiSkill->id,
            'price' => 120,
            'experience_level' => 'expert',
            'status' => 'active',
        ]);

        $listing4 = UserSkill::create([
            'user_id' => $mike->id,
            'skill_id' => $consultSkill->id,
            'price' => 200,
            'experience_level' => 'expert',
            'status' => 'active',
        ]);

        $listing5 = UserSkill::create([
            'user_id' => $sarah->id,
            'skill_id' => $marketingSkill->id,
            'price' => 100,
            'experience_level' => 'intermediate',
            'status' => 'active',
        ]);

        $listing6 = UserSkill::create([
            'user_id' => $jane->id,
            'skill_id' => $jsSkill->id,
            'price' => 130,
            'experience_level' => 'intermediate',
            'status' => 'active',
        ]);

        // Create purchases with different statuses
        $purchase1 = Purchase::create([
            'buyer_id' => $jane->id,
            'seller_id' => $john->id,
            'user_skill_id' => $listing1->id,
            'amount' => 150,
            'status' => 'completed',
            'note' => 'Need help with Laravel project setup and database design',
        ]);

        $purchase2 = Purchase::create([
            'buyer_id' => $john->id,
            'seller_id' => $jane->id,
            'user_skill_id' => $listing3->id,
            'amount' => 120,
            'status' => 'completed',
            'note' => 'Design new landing page for my SaaS product',
        ]);

        $purchase3 = Purchase::create([
            'buyer_id' => $mike->id,
            'seller_id' => $sarah->id,
            'user_skill_id' => $listing5->id,
            'amount' => 100,
            'status' => 'completed',
            'note' => 'Create marketing strategy for startup launch',
        ]);

        $purchase4 = Purchase::create([
            'buyer_id' => $sarah->id,
            'seller_id' => $john->id,
            'user_skill_id' => $listing2->id,
            'amount' => 180,
            'status' => 'accepted',
            'note' => 'Build REST API for mobile app',
        ]);

        $purchase5 = Purchase::create([
            'buyer_id' => $jane->id,
            'seller_id' => $mike->id,
            'user_skill_id' => $listing4->id,
            'amount' => 200,
            'status' => 'pending',
            'note' => 'Strategic planning for company expansion',
        ]);

        // Create coin transactions
        CoinTransaction::create([
            'user_id' => $jane->id,
            'type' => 'debit',
            'amount' => 150,
            'reason' => 'purchase',
            'reference_id' => $purchase1->id,
            'status' => 'success',
        ]);

        CoinTransaction::create([
            'user_id' => $john->id,
            'type' => 'credit',
            'amount' => 150,
            'reason' => 'purchase',
            'reference_id' => $purchase1->id,
            'status' => 'success',
        ]);

        CoinTransaction::create([
            'user_id' => $john->id,
            'type' => 'debit',
            'amount' => 120,
            'reason' => 'purchase',
            'reference_id' => $purchase2->id,
            'status' => 'success',
        ]);

        CoinTransaction::create([
            'user_id' => $jane->id,
            'type' => 'credit',
            'amount' => 120,
            'reason' => 'purchase',
            'reference_id' => $purchase2->id,
            'status' => 'success',
        ]);

        CoinTransaction::create([
            'user_id' => $mike->id,
            'type' => 'debit',
            'amount' => 100,
            'reason' => 'purchase',
            'reference_id' => $purchase3->id,
            'status' => 'success',
        ]);

        CoinTransaction::create([
            'user_id' => $sarah->id,
            'type' => 'credit',
            'amount' => 100,
            'reason' => 'purchase',
            'reference_id' => $purchase3->id,
            'status' => 'success',
        ]);

        // Create coin top-up transactions
        CoinTransaction::create([
            'user_id' => $john->id,
            'type' => 'credit',
            'amount' => 500,
            'reason' => 'topup',
            'status' => 'success',
        ]);

        CoinTransaction::create([
            'user_id' => $jane->id,
            'type' => 'credit',
            'amount' => 300,
            'reason' => 'topup',
            'status' => 'success',
        ]);

        // Create reviews for completed purchases
        $review1 = Review::create([
            'purchase_id' => $purchase1->id,
            'buyer_id' => $jane->id,
            'seller_id' => $john->id,
            'rating' => 5,
            'comment' => 'Excellent work! John provided clear guidance and solved all my issues. Highly recommended!',
        ]);

        $review2 = Review::create([
            'purchase_id' => $purchase2->id,
            'buyer_id' => $john->id,
            'seller_id' => $jane->id,
            'rating' => 5,
            'comment' => 'Jane created a stunning design! Very professional and delivered on time. Will hire again!',
        ]);

        $review3 = Review::create([
            'purchase_id' => $purchase3->id,
            'buyer_id' => $mike->id,
            'seller_id' => $sarah->id,
            'rating' => 4,
            'comment' => 'Good marketing strategy. A few things could have been more detailed, but overall very helpful.',
        ]);

        // Create notifications
        Notification::create([
            'user_id' => $john->id,
            'title' => 'New Purchase Request',
            'message' => 'Jane has requested your PHP Development service',
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $jane->id,
            'title' => 'Purchase Accepted',
            'message' => 'John has accepted your purchase request',
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $john->id,
            'title' => 'Purchase Completed',
            'message' => 'Your purchase from Jane has been completed and coins transferred',
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $jane->id,
            'title' => 'New Review',
            'message' => 'You received a 5-star review from John for your UI/UX Design service',
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $sarah->id,
            'title' => 'Coins Added',
            'message' => 'You received 100 coins from Mike for the completed Digital Marketing service',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $mike->id,
            'title' => 'Purchase Request Sent',
            'message' => 'Your business consulting request has been sent to Mike. Waiting for response.',
            'is_read' => false,
        ]);
    }
}
