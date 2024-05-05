<?php

namespace App\Models;

use App\Orchid\Presenters\Category\CategoryPresenter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string name
 * @property int $external_id
 * @property int $index
 * @property bool $is_show
 *
 * @property Collection $dishes
 */
class Category extends Model
{
    use AsSource, Filterable, Attachable;

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'preview_image',
        'external_id',
        'index',
        'is_show',
    ];

    protected array $allowedFilters = [
        'name' => Like::class,
        'is_show' => Where::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    protected array $allowedSorts = [
        'name',
        'is_show',
        'updated_at',
        'created_at',
    ];

    public function presenter(): CategoryPresenter
    {
        return new CategoryPresenter($this);
    }

    /**
     * @return HasMany
     */
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class, 'category_external_id', 'external_id')
            ->where('is_show', true);
    }
}
