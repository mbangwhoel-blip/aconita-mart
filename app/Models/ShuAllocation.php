<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShuAllocation extends Model
{
    protected $fillable = [
        'year', 'total_revenue', 'total_profit',
        'member_share_percentage', 'member_shu_pool', 'notes'
    ];

    protected $casts = [
        'total_revenue' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'member_share_percentage' => 'decimal:2',
        'member_shu_pool' => 'decimal:2',
    ];
}
