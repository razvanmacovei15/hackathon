<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadDebtCategory extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'is_default',
        'description'
    ];

    public function userBadDebts()
    {
        return $this->hasMany(UserBadDebt::class, 'category_id');
    }
} 