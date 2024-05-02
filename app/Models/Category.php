<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'preview_image',
        'external_id',
        'index',
        'is_show',
    ];

    /**
     * @return HasMany
     */
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class, 'category_external_id', 'external_id')
            ->where('is_show', true);
    }
}
