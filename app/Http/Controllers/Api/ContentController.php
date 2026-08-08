<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use App\Support\ContentCache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

/**
 * The whole editable surface of the site for one language, in a single
 * request: `content` mirrors the shape the Next.js dictionaries have, and
 * `seo` carries the per-page meta overrides.
 *
 * The frontend merges `content` over its bundled dictionary, so a missing key
 * (or an unreachable API) degrades to the shipped copy instead of a blank page.
 */
class ContentController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $payload = Cache::remember(
            ContentCache::contentKey($locale),
            now()->addMinutes(ContentCache::TTL_MINUTES),
            fn () => [
                'locale' => $locale,
                'content' => $this->contentTree($locale),
                'seo' => $this->seoByPage($locale),
            ]
        );

        return response()->json(['data' => $payload]);
    }

    /**
     * Sections rebuilt into one nested tree. Shallow keys are written first so
     * that a parent section (`about`) can never overwrite a child that was
     * filed separately (`about.founder`).
     *
     * @return array<string, mixed>
     */
    private function contentTree(string $locale): array
    {
        $sections = PageSection::query()
            ->visible()
            ->orderBy('sort_order')
            ->get()
            ->sortBy(fn (PageSection $section) => substr_count($section->key, '.'));

        $tree = [];

        foreach ($sections as $section) {
            $value = $section->resolve($locale);
            if ($value === []) {
                continue;
            }

            $unwrap = config("sections.types.{$section->type}.unwrap");
            if ($unwrap) {
                $value = $value[$unwrap] ?? [];
            }

            // `pairs` is the free-form escape hatch — its key/value map is
            // lifted into the section itself.
            if (isset($value['pairs']) && is_array($value['pairs'])) {
                $value = array_merge(Arr::except($value, 'pairs'), $value['pairs']);
            }

            Arr::set($tree, $section->key, $value);
        }

        return $tree;
    }

    /**
     * Meta overrides per page key. Empty values are stripped: the frontend
     * keeps its computed default whenever the admin left a field blank.
     *
     * @return array<string, array<string, mixed>>
     */
    private function seoByPage(string $locale): array
    {
        return Page::query()
            ->orderBy('sort_order')
            ->get()
            ->mapWithKeys(function (Page $page) use ($locale) {
                $seo = array_filter(
                    $page->seoFor($locale),
                    fn ($value) => $value !== null && $value !== ''
                );

                return [$page->key => $seo];
            })
            ->all();
    }
}
