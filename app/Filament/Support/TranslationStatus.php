<?php

namespace App\Filament\Support;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

/**
 * With six content locales a half-translated row is easy to miss: the API
 * silently falls back to the default locale, so the site still looks fine.
 * This column names the locales that still need work, straight in the list.
 */
class TranslationStatus
{
    /**
     * Locale codes still missing at least one of the given translatable fields.
     *
     * @param  array<int, string>  $fields
     * @return array<int, string>
     */
    public static function missing(Model $record, array $fields): array
    {
        $missing = [];

        foreach (config('locales.supported', []) as $locale) {
            foreach ($fields as $field) {
                if (blank($record->getTranslations($field)[$locale] ?? null)) {
                    $missing[] = strtoupper($locale);
                    break;
                }
            }
        }

        return $missing ?: ['complete'];
    }

    /**
     * @param  array<int, string>  $fields  Translatable fields that must be filled.
     */
    public static function column(array $fields): TextColumn
    {
        return TextColumn::make('translation_status')
            ->label('Languages')
            ->badge()
            ->getStateUsing(fn (Model $record) => self::missing($record, $fields))
            ->color(fn (string $state) => $state === 'complete' ? 'success' : 'danger')
            ->tooltip('Locales still missing a translation');
    }
}
