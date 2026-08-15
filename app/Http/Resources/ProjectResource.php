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
            'video_file' => $this->mediaUrl($this->video_file),
            'video_url' => $this->video_url ?: null,
            'title' => $this->getTranslation('title', $locale),
            'summary' => $this->getTranslation('summary', $locale),
            // Rich-text HTML from the admin editor.
            'body' => $this->getTranslation('body', $locale),
            // Feeds <lastmod> in the sitemap, so it has to be the real edit date.
            'updated_at' => $this->updated_at?->toIso8601String(),
            'seo' => $this->seoFor($locale),
        ];
    }
}
