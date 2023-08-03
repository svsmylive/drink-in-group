<?php

namespace App\Models;

use App\Orchid\Presenters\Event\EventPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property int $institution_id
 * @property string $name
 * @property string $text
 * @property string $date
 * @property string $time
 */
class Event extends Model
{
    use AsSource, Filterable, Attachable;

    protected $table = 'events';

    public const FILLABLE = [
        'institution_id',
        'name',
        'text',
        'date',
        'time',
    ];

    protected $fillable = self::FILLABLE;

    protected array $allowedFilters = [
        'name' => Like::class,
        'text' => Like::class,
        'date' => Where::class,
        'time' => Where::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    protected array $allowedSorts = [
        'name',
        'text',
        'date',
        'time',
        'updated_at',
        'created_at',
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function presenter(): EventPresenter
    {
        return new EventPresenter($this);
    }

    public function scopeFreeRelation(Builder $query): Builder
    {
        return $query->whereNull('institution_id');
    }
}
