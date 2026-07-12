<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyListing extends Model
{
    public const CARD_COLUMNS = [
        'id',
        'title',
        'slug',
        'type',
        'property_type',
        'status',
        'city',
        'region',
        'price',
        'currency',
        'bedrooms',
        'bathrooms',
        'area_sqm',
        'description',
        'image_paths',
        'latitude',
        'longitude',
        'is_investment',
        'is_new',
        'team_member_id',
        'created_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'type',
        'property_type',
        'property_code',
        'status',
        'address',
        'city',
        'region',
        'community_id',
        'team_member_id',
        'price',
        'currency',
        'bedrooms',
        'bathrooms',
        'garages',
        'floors',
        'year_built',
        'area_sqm',
        'description',
        'features',
        'image_paths',
        'video_url',
        'virtual_tour_url',
        'floor_plan_paths',
        'nearby_places',
        'title_status',
        'latitude',
        'longitude',
        'is_featured',
        'is_investment',
        'is_new',
        'is_published',
        'sold_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'area_sqm' => 'decimal:2',
            'features' => 'array',
            'image_paths' => 'array',
            'floor_plan_paths' => 'array',
            'nearby_places' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_featured' => 'boolean',
            'is_investment' => 'boolean',
            'is_new' => 'boolean',
            'is_published' => 'boolean',
            'sold_at' => 'datetime',
        ];
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id');
    }

    public function primaryImage(): string
    {
        return $this->image_paths[0] ?? '/light/images/all/1.jpg';
    }

    public function formattedPrice(): string
    {
        return $this->currency.' '.number_format((float) $this->price, 2);
    }

    public static function propertyTypeOptions(): array
    {
        return [
            'house' => 'House',
            'apartment' => 'Apartment',
            'villa' => 'Villa',
            'land' => 'Land',
            'commercial' => 'Commercial',
            'office' => 'Office',
            'warehouse' => 'Warehouse',
            'mixed-use' => 'Mixed-use',
        ];
    }
}
