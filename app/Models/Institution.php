<?php

namespace App\Models;

use App\Orchid\Presenters\Institution\InstitutionPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property string $type
 * @property string $city
 * @property string $address
 * @property string $full_address
 * @property string $time_of_work
 * @property string $phone
 * @property boolean $active
 * @property string $about_detail_text_header
 * @property string $about_detail_text_body
 * @property string $about_detail_text_footer
 * @property string $title
 * @property string $description
 * @property string $url
 * @property string $event_text_header
 * @property string $event_text_footer
 * @property string $services_and_prices_text_header
 * @property string $services_and_prices_text_footer
 * @property string $services_and_prices_capacity
 * @property string $services_and_prices_price
 * @property array $services_and_prices_include
 * @property array $services_and_prices_additionally_include
 */
class Institution extends Model
{
    use AsSource, Filterable, Attachable;

    protected $table = 'institutions';

    public const SAUNA_TYPE = 'Сауна';

    private const TYPES_OF_INSTITUTIONS = [
        'Ресторан',
        'Караоке',
        'Сауна',
        'Бильярдная',
    ];

    private const SAUNA_INCLUDES = [
        'Финская сауна',
        'Бассейн с гидромассажем, водопадом и гейзером',
        'Камин',
        'Купель',
        'Банные принадлежности',
        'Кальян',
        'Караоке',
        'Бильярд',
        'Спутниковое TV',
        'Домашний кинотеатр',
        'Аудио / видео аппаратура',
        'Банкетный зал',
    ];

    private const SAUNA_INCLUDES_ADDITIONALLY = [
        'Массаж'
    ];

    public const FILLABLE = [
        'name',
        'type',
        'city',
        'address',
        'full_address',
        'time_of_work',
        'phone',
        'active',
        'about_detail_text_header',
        'about_detail_text_body',
        'about_detail_text_footer',
        'event_text_header',
        'event_text_footer',
        'services_and_prices_text_header',
        'services_and_prices_text_footer',
        'services_and_prices_capacity',
        'services_and_prices_price',
        'services_and_prices_include',
        'services_and_prices_additionally_include',
        'title',
        'description',
        'url',
    ];

    protected $fillable = self::FILLABLE;

    protected $with = ['events'];

    protected $casts = [
        'services_and_prices_include' => 'array',
        'services_and_prices_additionally_include' => 'array',
    ];

    protected array $allowedFilters = [
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
        'time_of_work',
        'phone',
        'active',
        'updated_at',
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

    public static function getSaunaIncludes(): array
    {
        return collect(static::SAUNA_INCLUDES)->map(function ($include) {
            return [$include => $include];
        })
            ->collapse()
            ->toArray();
    }

    public static function getSaunaIncludesAdditionally(): array
    {
        return collect(static::SAUNA_INCLUDES_ADDITIONALLY)->map(function ($include) {
            return [$include => $include];
        })
            ->collapse()
            ->toArray();
    }

    public function detailImages(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where(
            'group',
            'detailImages'
        )->orderBy('sort');
    }

    public function sliderImagesDesktop(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where(
            'group',
            'sliderImagesDesktop'
        )->orderBy('sort');
    }

    public function sliderImagesMobile(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where(
            'group',
            'sliderImagesMobile'
        )->orderBy('sort');
    }

    public function logo(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where('group', 'logo');
    }

    public function menu(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where('group', 'menu');
    }

    public function saunaImage(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where(
            'group',
            'saunaImage'
        )->orderBy('sort');
    }

    public function menuBackgroundImage(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where(
            'group',
            'menuBackgroundImage'
        )->orderBy('sort');
    }

    public function institutionBackgroundImage(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where(
            'group',
            'institutionBackgroundImage'
        )->orderBy('sort');
    }

    public function reserveBackgroundImage(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where(
            'group',
            'reserveBackgroundImage'
        )->orderBy('sort');
    }

    public function eventBackgroundImage(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where(
            'group',
            'eventBackgroundImage'
        )->orderBy('sort');
    }

    public function priceAndServicesBackgroundImage(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable')->where(
            'group',
            'priceAndServicesBackgroundImage'
        )->orderBy('sort');
    }
}
