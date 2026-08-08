<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'title' => $this->getTranslation('title', $locale),
            'summary' => $this->getTranslation('summary', $locale),
            'description' => $this->getTranslation('description', $locale),
            'features' => $this->getTranslation('features', $locale) ?: [],
            'sort_order' => $this->sort_order,
            'seo' => $this->seoFor($locale),
        ];
    }
}
