<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $table = 'events';

    public const FILLABLE = [
        'institution_id',
        'name',
        'text',
        'date',
        'time',
        'path_to_image',
    ];

    protected $fillable = self::FILLABLE;

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }
}
