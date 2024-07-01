<?php

namespace App\Models;

use App\Orchid\Presenters\Dish\DishPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property string $detail_text
 * @property string|null $preview_image
 * @property int $price
 * @property int $external_id
 * @property int $category_external_id
 * @property bool $is_show
 * @property int $index,
 * @property int $institution_id,
 * @property float|null $mitm_Volume - вес товара в кг
 *
 * @property Category $category
 */
class Dish extends Model
{
    use AsSource, Filterable, Attachable;

    protected $table = 'dishes';

    protected $fillable = [
        'id',
        'name',
        'detail_text',
        'price',
        'mvtp_ID',
        'category_external_id',
        'external_id',
        'is_show',
        'institution_id',
        'preview_image',
        'mitm_Volume',
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
        'price',
    ];

    public function presenter(): DishPresenter
    {
        return new DishPresenter($this);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_external_id', 'external_id')
            ->where('is_show', true);
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id', 'id');
    }

    public function image(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable');
    }
}
