<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property array $slider_images_links
 * @property string $about_detail_text
 */
class Institution extends Model
{
    use AsSource;

    protected $table = 'institutions';

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
        'slider_images_links',
        'about_detail_text',
    ];

    protected $fillable = self::FILLABLE;

    protected $casts = [
        'slider_images_links' => 'array',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
