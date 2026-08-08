<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\ResolvesMedia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    use ResolvesMedia;

    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'client' => $this->client,
            'year' => $this->year,
            'url' => $this->url,
            'cover_image' => $this->imageUrl($this->cover_image),
            'gallery' => collect($this->gallery ?? [])
                ->map(fn ($path) => $this->imageUrl($path))
                ->filter()
                ->values()
                ->all(),
            'title' => $this->getTranslation('title', $locale),
            'summary' => $this->getTranslation('summary', $locale),
            'problem' => $this->getTranslation('problem', $locale),
            'solution' => $this->getTranslation('solution', $locale),
            'result' => $this->getTranslation('result', $locale),
            'seo' => $this->seoFor($locale),
        ];
    }
}
