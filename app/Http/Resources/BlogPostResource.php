<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\ResolvesMedia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
{
    use ResolvesMedia;

    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        $detailed = (bool) $request->route()?->parameter('slug');

        $data = [
            'id' => $this->id,
            'slug' => $this->slug,
            'cover_image' => $this->imageUrl($this->cover_image),
            'read_minutes' => $this->read_minutes,
            'published_at' => $this->published_at?->toIso8601String(),
            // Drives <lastmod> and the `dateModified` of the BlogPosting markup,
            // both of which have to be the real edit date rather than "now".
            'updated_at' => $this->updated_at?->toIso8601String(),
            'author' => $this->whenLoaded('author', fn () => [
                'name' => $this->author?->name,
            ]),
            'title' => $this->getTranslation('title', $locale),
            'excerpt' => $this->getTranslation('excerpt', $locale),
            'seo' => $this->seoFor($locale),
        ];

        if ($detailed) {
            $data['content'] = $this->getTranslation('content', $locale);
        }

        return $data;
    }
}
