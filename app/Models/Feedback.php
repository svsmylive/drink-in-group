<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $institution_id
 * @property string $name
 * @property string $phone
 * @property string $date
 * @property string $time
 * @property string|null $count_guests
 * @property string|null $comment
 */
class Feedback extends Model
{
    protected $table = 'feedbacks';

    public const FILLABLE = [
        'institution_id',
        'name',
        'phone',
        'date',
        'time',
        'count_guests',
        'comment',
    ];

    protected $fillable = self::FILLABLE;
}
