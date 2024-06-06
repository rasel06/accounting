<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_method',
        'invoice_number',
        'description',
        'user_id',
        'invoice_date',
        'invoice_file',
        'number_of_unit',
        'unit_price',
        'total',
        'remarks',
        'payment_method_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'payment_method' => 'integer',
        'user_id' => 'integer',
        'invoice_date' => 'timestamp',
        'number_of_unit' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
        'payment_method_id' => 'integer',
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
