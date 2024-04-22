<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'info',
        'transaction_id',
        'amount',
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
}
