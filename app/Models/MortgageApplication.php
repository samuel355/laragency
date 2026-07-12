<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MortgageApplication extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'property_listing_id',
        'partner_bank_id',
        'property_price',
        'down_payment',
        'monthly_income',
        'loan_term_years',
        'employment_status',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'property_price' => 'decimal:2',
            'down_payment' => 'decimal:2',
            'monthly_income' => 'decimal:2',
        ];
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(PropertyListing::class, 'property_listing_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(PartnerBank::class, 'partner_bank_id');
    }
}
