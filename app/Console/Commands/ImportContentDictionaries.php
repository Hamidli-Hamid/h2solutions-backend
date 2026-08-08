<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\PageSection;
use App\Support\ContentCache;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

/**
 * Seeds the editable content tables from the Next.js dictionary files, which
 * were the site's copy before it became admin-managed. Running it after adding
 * a page or section to config/sections.php creates only the missing rows, so
 * an editor's work is never overwritten unless --overwrite is passed.
 */
class ImportContentDictionaries extends Command
{
    protected $signature = 'content:import
        {--overwrite : Replace the stored copy of sections that already exist}
        {--path= : Directory holding the <locale>.json dictionaries}';

    protected $description = 'Create pages and sections from the frontend dictionary files';

    public function handle(): int
    {
        $directory = rtrim(
            $this->option('path')
                ?? env('H2_DICTIONARY_PATH', base_path('../frontend/src/dictionaries')),
            '/'
        );

        $locales = config('locales.supported', ['az']);
        $dictionaries = [];

        foreach ($locales as $locale) {
            $file = "$directory/$locale.json";
            if (! is_file($file)) {
                $this->warn("No dictionary for [$locale] at $file — skipped.");
                continue;
            }
            $dictionaries[$locale] = json_decode(file_get_contents($file), true) ?: [];
        }

        if ($dictionaries === []) {
            $this->error("No dictionaries found in $directory.");

            return self::FAILURE;
        }

        $created = 0;
        $updated = 0;
        $sortOrder = 0;

        foreach (config('sections.pages', []) as $pageKey => $config) {
            $page = Page::updateOrCreate(
                ['key' => $pageKey],
                [
                    'group' => $config['group'] ?? 'page',
                    'label' => $config['label'] ?? $pageKey,
                    'path' => $config['path'] ?? null,
                    'sort_order' => $sortOrder += 10,
                ]
            );

            $sectionOrder = 0;

            foreach ($config['sections'] ?? [] as $sectionKey => $type) {
                $sectionOrder += 10;
                $existing = PageSection::where('key', $sectionKey)->first();

                if ($existing && ! $this->option('overwrite')) {
                    // Keep the page/type wiring in sync without touching content.
                    $existing->update([
                        'page_id' => $page->id,
                        'type' => $type,
                        'sort_order' => $sectionOrder,
                    ]);
                    continue;
                }

                [$data, $shared] = $this->extract($type, $sectionKey, $dictionaries);

                PageSection::updateOrCreate(
                    ['key' => $sectionKey],
                    [
                        'page_id' => $page->id,
                        'type' => $type,
                        'data' => $data,
                        'shared' => $shared,
                        'is_visible' => true,
                        'sort_order' => $sectionOrder,
                    ]
                );

                $existing ? $updated++ : $created++;
            }
        }

        ContentCache::flushContent();

        $this->info("Content import finished — $created section(s) created, $updated updated.");

        return self::SUCCESS;
    }

    /**
     * Split one dictionary node into per-locale content and the values that are
     * the same in every language.
     *
     * @param  array<string, array<string, mixed>>  $dictionaries
     * @return array{0: array<string, mixed>, 1: array<string, mixed>}
     */
    private function extract(string $type, string $sectionKey, array $dictionaries): array
    {
        $fields = config("sections.types.$type.fields", []);
        $unwrap = config("sections.types.$type.unwrap");
        $sharedNames = array_keys(array_filter(
            $fields,
            fn (array $field) => ($field['shared'] ?? false) === true
        ));

        $data = [];
        $shared = [];

        foreach ($dictionaries as $locale => $dictionary) {
            $value = Arr::get($dictionary, $sectionKey);
            if ($value === null) {
                continue;
            }

            // A node the frontend reads as a bare list is stored under the
            // field name the schema gives it.
            $value = $unwrap ? [$unwrap => $value] : (array) $value;

            foreach ($sharedNames as $name) {
                $sharedValue = Arr::get($value, $name);
                if ($sharedValue !== null && ! Arr::has($shared, $name)) {
                    Arr::set($shared, $name, $sharedValue);
                }
                Arr::forget($value, $name);
            }

            // Forgetting `social.linkedin` leaves an empty `social` behind.
            $data[$locale] = array_filter($value, fn ($item) => $item !== []);
        }

        return [$data, $shared];
    }
}
