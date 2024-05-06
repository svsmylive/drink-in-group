<?php

namespace App\Http\Resources\Institutions;

use App\Http\Resources\Attachments\AttachmentsResource;
use App\Http\Resources\Events\EventsResource;
use App\Models\Institution;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Institution */
class InstitutionsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'has_booking' => $this->has_booking,
            'has_delivery' => $this->has_delivery,
            'name' => $this->name,
            'type' => $this->type,
            'city' => $this->city,
            'address' => $this->address,
            'full_address' => $this->full_address,
            'menu' => new AttachmentsResource($this->whenNotNull($this->menu()->exists() ? $this->menu()->first() : null)),
            'time_of_work' => $this->time_of_work,
            'phone' => $this->phone,
            'active' => $this->active,
            'logo' => new AttachmentsResource($this->whenNotNull($this->logo()->exists() ? $this->logo()->first() : null)),
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'about' => [
                'about_detail_text_header' => $this->about_detail_text_header,
                'about_detail_text_body' => $this->about_detail_text_body,
                'about_detail_text_footer' => $this->about_detail_text_footer,
                'images' => AttachmentsResource::collection($this->whenNotNull($this->detailImages()->exists() ? $this->detailImages()->get() : null))
            ],
            'event' => [
                'event_text_header' => $this->event_text_header,
                'event_text_footer' => $this->event_text_footer,
                'image' => EventsResource::collection($this->whenNotNull($this->events()->exists() ? $this->events()->get() : null)),
            ],
            'slider_images_desktop' => AttachmentsResource::collection($this->whenNotNull($this->sliderImagesDesktop()->exists() ? $this->sliderImagesDesktop()->get() : null)),
            'slider_images_mobile' => AttachmentsResource::collection($this->whenNotNull($this->sliderImagesMobile()->exists() ? $this->sliderImagesMobile()->get() : null)),
            'sauna_services_and_prices' => $this->when($this->type == Institution::SAUNA_TYPE, function () {
                return [
                    'services_and_prices_text_header' => $this->services_and_prices_text_header,
                    'services_and_prices_text_footer' => $this->services_and_prices_text_footer,
                    'services_and_prices_capacity' => $this->services_and_prices_capacity,
                    'services_and_prices_price' => $this->services_and_prices_price,
                    'services_and_prices_include' => $this->services_and_prices_include,
                    'services_and_prices_additionally_include' => $this->services_and_prices_additionally_include,
                    'image' => new AttachmentsResource($this->whenNotNull($this->saunaImage()->exists() ? $this->saunaImage()->first() : null))
                ];
            }),
            'background_images' => [
                'menu' => new AttachmentsResource($this->whenNotNull($this->menuBackgroundImage()->exists() ? $this->menuBackgroundImage()->first() : null)),
                'about' => new AttachmentsResource($this->whenNotNull($this->institutionBackgroundImage()->exists() ? $this->institutionBackgroundImage()->first() : null)),
                'events' => new AttachmentsResource($this->whenNotNull($this->eventBackgroundImage()->exists() ? $this->eventBackgroundImage()->first() : null)),
                'reserve' => new AttachmentsResource($this->whenNotNull($this->reserveBackgroundImage()->exists() ? $this->reserveBackgroundImage()->first() : null)),
                'services' => new AttachmentsResource($this->whenNotNull($this->priceAndServicesBackgroundImage()->exists() ? $this->priceAndServicesBackgroundImage()->first() : null)),
            ],
        ];
    }
}
