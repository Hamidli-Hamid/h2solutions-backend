<?php

namespace App\Models\Concerns;

/**
 * The SEO override block shared by every addressable record (pages and the
 * three content models). Blank fields mean "keep the frontend default", so a
 * record only carries what an editor actually chose to override.
 *
 * Requires spatie/laravel-translatable's HasTranslations on the model — the
 * text fields are stored per locale exactly like the rest of the content.
 */
trait HasSeo
{
    /** Translated per locale. */
    public static function seoTranslatable(): array
    {
        return ['seo_title', 'seo_description'];
    }

    /** Identical in every language. */
    public static function seoShared(): array
    {
        return ['og_image', 'robots_index', 'robots_follow'];
    }

    /** @return array<int, string> */
    public static function seoFields(): array
    {
        return [...self::seoTranslatable(), ...self::seoShared()];
    }

    public function initializeHasSeo(): void
    {
        $this->translatable = array_values(array_unique(
            array_merge($this->translatable ?? [], self::seoTranslatable())
        ));

        $this->mergeFillable(self::seoFields());
        $this->mergeCasts([
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
        ]);
    }

    /**
     * SEO overrides resolved for one locale. Empty strings are dropped so the
     * frontend can fall back with a plain `??`.
     *
     * @return array<string, mixed>
     */
    public function seoFor(?string $locale = null): array
    {
        $locale ??= app()->getLocale();

        $text = [];
        foreach (self::seoTranslatable() as $field) {
            $value = $this->getTranslation($field, $locale, false);
            $text[$field] = filled($value) ? $value : null;
        }

        return [
            // The share card reuses the meta title and description; only the
            // image differs, so there is nothing else to override here.
            'title' => $text['seo_title'],
            'description' => $text['seo_description'],
            'og_image' => $this->og_image ? asset('storage/' . ltrim($this->og_image, '/')) : null,
            'robots' => [
                'index' => (bool) ($this->robots_index ?? true),
                'follow' => (bool) ($this->robots_follow ?? true),
            ],
        ];
    }
}
