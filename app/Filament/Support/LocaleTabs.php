<?php

namespace App\Filament\Support;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Tabs;

class LocaleTabs
{
    /**
     * Wrap the given field templates inside one Tab per supported locale.
     * Field names use `%locale%` as placeholder — it is replaced with the
     * locale code (e.g. `title.%locale%` becomes `title.az`). spatie/laravel-
     * translatable maps `field.locale` notation directly to JSON entries.
     *
     * @param  array<int, Component>  $fieldTemplates
     * @return array<int, Tabs>
     */
    public static function make(array $fieldTemplates): array
    {
        $locales = config('locales.supported', ['az']);
        $labels = config('locales.labels', []);

        $tabs = [];
        foreach ($locales as $locale) {
            $fields = array_map(
                fn (Component $template) => self::cloneWithLocale($template, $locale),
                $fieldTemplates
            );

            $label = strtoupper($locale) . ' · ' . ($labels[$locale] ?? $locale);
            $tabs[] = Tabs\Tab::make($label)->schema($fields);
        }

        return [Tabs::make('locales')->tabs($tabs)->columnSpanFull()];
    }

    /**
     * Same tabs, but each locale gets freshly built fields instead of clones.
     * Use this whenever a field owns a nested schema (repeaters, groups) —
     * cloning would leave the children pointing at the first tab's container.
     *
     * @param  callable(string): array<int, Component>  $factory
     * @return array<int, Tabs>
     */
    public static function build(callable $factory): array
    {
        $labels = config('locales.labels', []);
        $tabs = [];

        foreach (config('locales.supported', ['az']) as $locale) {
            $label = strtoupper($locale) . ' · ' . ($labels[$locale] ?? $locale);
            $tabs[] = Tabs\Tab::make($label)->schema($factory($locale));
        }

        return [Tabs::make('locales')->tabs($tabs)->columnSpanFull()];
    }

    private static function cloneWithLocale(Component $template, string $locale): Component
    {
        $clone = clone $template;
        $name = str_replace('%locale%', $locale, $clone->getName());
        $clone->name($name);
        $clone->statePath($name);

        return $clone;
    }
}
