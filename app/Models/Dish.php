<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $detail_text
 * @property int $price
 * @property int $external_id
 * @property int $category_external_id
 * @property bool $is_show
 * @property int $index
 *
 * @property Category $category
 */
class Dish extends Model
{
    use HasFactory;

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
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_external_id', 'external_id')
            ->where('is_show', true);
    }
}
