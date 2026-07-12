<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerBank extends Model
{
    protected $fillable = [
        'name',
        'logo_path',
        'url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
