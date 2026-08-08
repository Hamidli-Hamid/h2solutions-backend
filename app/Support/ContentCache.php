<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

/**
 * One place that knows the cache keys the public API reads, so any model that
 * changes editable content can invalidate them without repeating the loop.
 */
class ContentCache
{
    public const TTL_MINUTES = 15;

    /** Cache key for the assembled content tree of one locale. */
    public static function contentKey(string $locale): string
    {
        return "api.content.$locale";
    }

    /** @return array<int, string> */
    public static function locales(): array
    {
        return config('locales.supported', [config('locales.default', 'az')]);
    }

    /** Drop the assembled page/section tree for every locale. */
    public static function flushContent(): void
    {
        foreach (self::locales() as $locale) {
            Cache::forget(self::contentKey($locale));
        }

        FrontendRevalidator::ping();
    }

    /**
     * Drop a collection endpoint plus one record of it, for every locale —
     * e.g. flush('services', 'service', 'seo-audit').
     */
    public static function flushEntity(string $collectionKey, string $itemKey, ?string $slug = null): void
    {
        foreach (self::locales() as $locale) {
            Cache::forget("api.$collectionKey.$locale");

            if ($slug !== null) {
                Cache::forget("api.$itemKey.$slug.$locale");
            }
        }

        FrontendRevalidator::ping();
    }
}
