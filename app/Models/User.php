<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_image',
        'bio',
        'coins',
        'role',
        'phone_number',
        'transaction_pin',
        'isverified',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'transaction_pin',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'coins' => 'decimal:2',
        ];
    }

    // Relationships
    public function skills()
    {
        return $this->hasMany(Skill::class, 'created_by');
    }

    public function userSkills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function purchasesAsBuyer()
    {
        return $this->hasMany(Purchase::class, 'buyer_id');
    }

    public function purchasesAsSeller()
    {
        return $this->hasMany(Purchase::class, 'seller_id');
    }

    public function coinTransactions()
    {
        return $this->hasMany(CoinTransaction::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function reviewsAsReviewer()
    {
        return $this->hasMany(Review::class, 'buyer_id');
    }

    public function reviewsAsReviewee()
    {
        return $this->hasMany(Review::class, 'seller_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
