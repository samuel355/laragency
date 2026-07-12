<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'plot_number',
        'title',
        'location_name',
        'price',
        'currency',
        'area_sqm',
        'status',
        'geometry',
        'attributes',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'area_sqm' => 'decimal:2',
            'geometry' => 'array',
            'attributes' => 'array',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function toGeoJsonFeature(): array
    {
        return [
            'type' => 'Feature',
            'geometry' => $this->geometry,
            'properties' => [
                'id' => $this->id,
                'plot_number' => $this->plot_number,
                'title' => $this->title,
                'location_name' => $this->location_name,
                'price' => (float) $this->price,
                'currency' => $this->currency,
                'area_sqm' => (float) $this->area_sqm,
                'status' => $this->status,
                'status_label' => $this->statusLabel(),
                'status_color' => $this->statusColor(),
                'attributes' => $this->parcelAttributes(),
                'checkout_url' => route('parcels.checkout.show', $this),
                'detail_url' => route('parcels.show', $this),
            ],
        ];
    }

    public function parcelAttributes(): array
    {
        return $this->getAttribute('attributes') ?? [];
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'sold' => 'Sold',
            'reserved' => 'Reserved',
            'on_hold' => 'On hold',
            default => 'Available',
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'sold' => '#e3342f',
            'reserved' => '#071f49',
            'on_hold' => '#808080',
            default => '#16a34a',
        };
    }
}
