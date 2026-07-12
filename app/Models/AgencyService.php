<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyService extends Model
{
    protected $fillable = ['title', 'slug', 'summary', 'body', 'process', 'benefits', 'icon', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'process' => 'array',
            'benefits' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
