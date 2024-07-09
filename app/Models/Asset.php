<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'store_id',
        'asset_type_id',
        'account_id',
        'txn_date',
        'amount',
        'remarks',
        'user_id'
    ];


    public function account(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function assetType(): BelongsTo
    {
        return $this->belongsTo(AssetType::class);
    }
}
