<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'member_no', 'nik', 'name', 'phone', 'email',
        'department', 'savings_balance', 'credit_limit', 'is_active'
    ];

    protected $casts = [
        'savings_balance' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function savingsTransactions(): HasMany
    {
        return $this->hasMany(MemberSavingsTransaction::class);
    }
}
