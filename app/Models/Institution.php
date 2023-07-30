<?php

namespace App\Models;

use App\Orchid\Presenters\Institution\InstitutionPresenter;
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
 * @property string $name
 * @property string $type
 * @property string $city
 * @property string $address
 * @property string $full_address
 * @property string $menu_link
 * @property string $time_of_work
 * @property string $phone
 * @property boolean $active
 * @property string $about_detail_text
 */
class Institution extends Model
{
    use AsSource, Filterable, Attachable;

    protected $table = 'institutions';

    private const TYPES_OF_INSTITUTIONS = [
        'Ресторан', 'Караоке', 'Сауна',
    ];

    public const FILLABLE = [
        'name',
        'type',
        'city',
        'address',
        'full_address',
        'menu_link',
        'time_of_work',
        'phone',
        'active',
        'about_detail_text',
    ];

    protected $fillable = self::FILLABLE;

    protected array $allowedFilters = [
        'id' => Where::class,
        'name' => Like::class,
        'type' => Like::class,
        'active' => Where::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    protected array $allowedSorts = [
        'name',
        'type',
        'city',
        'address',
        'full_address',
        'menu_link',
        'time_of_work',
        'phone',
        'active',
        'about_detail_text',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function presenter(): InstitutionPresenter
    {
        return new InstitutionPresenter($this);
    }

    public static function getTypes(): array
    {
        return collect(static::TYPES_OF_INSTITUTIONS)->map(function ($type) {
            return [$type => $type];
        })
            ->collapse()
            ->toArray();
    }
}
