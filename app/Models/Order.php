<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'info',
        'transaction_id',
        'amount',
        'institution_id',
    ];

    /**
     * @param string $transactionId
     * @return Order|Model|null
     */
    public static function findByTransactionId(string $transactionId): Order|Model|null
    {
        return Order::query()
            ->where('transaction_id', $transactionId)
            ->first();
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}
