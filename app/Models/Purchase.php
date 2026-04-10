<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'user_skill_id',
        'amount',
        'status',
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function userSkill()
    {
        return $this->belongsTo(UserSkill::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Scope to check for active purchases (pending or accepted)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'accepted']);
    }

    /**
     * Check if there's already an active purchase for a buyer-skill combination
     */
    public static function hasActivePurchase($buyerId, $userSkillId)
    {
        return self::where('buyer_id', $buyerId)
                   ->where('user_skill_id', $userSkillId)
                   ->active()
                   ->exists();
    }
}
