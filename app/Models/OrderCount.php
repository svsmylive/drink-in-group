<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $count
 */
class OrderCount extends Model
{
    protected $table = 'orders_count';

    protected $fillable = [
        'count'
    ];
}
