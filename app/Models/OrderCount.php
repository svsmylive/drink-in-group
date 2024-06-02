<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $count
 * @property integer $institution_id
 */
class OrderCount extends Model
{
    protected $table = 'orders_count';

    protected $fillable = [
        'count',
        'institution_id',
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}
