<?php

namespace App\Models;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreditTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_account_id',
        'description',
        'invoice_number',
        'invoice_date',
        'invoice_file',
        'amount',
        'remarks',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'payment_method_id' => 'integer',
        'amount' => 'decimal:2',

    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function creditAccount(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'credit_account_id');
    }
}
