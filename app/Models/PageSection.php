<?php

namespace App\Models;

use App\Support\ContentCache;
use App\Support\IconGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

/**
 * A block of editable content filed under a page.
 *
 * `key` is the dotted path the section occupies in the content tree the
 * frontend consumes (`home.faq`, `about.founder`, `footer`), and `type` picks
 * the field schema from config/sections.php. Content lives in `data`, keyed by
 * locale; values that must not differ per language live in `shared`.
 *
 * Storage is a plain JSON cast rather than spatie/laravel-translatable because
 * each locale holds a whole structure (lists, repeaters), not one string.
 */
class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'key',
        'type',
        'data',
        'shared',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'data' => 'array',
        'shared' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /** Field descriptors for this section's type. */
    public function schema(): array
    {
        return config("sections.types.{$this->type}.fields", []);
    }

    public function typeLabel(): string
    {
        return config("sections.types.{$this->type}.label", $this->type);
    }

    /**
     * Content for one locale, falling back per field to the default locale so a
     * half-translated section never renders as a blank block.
     *
     * @return array<string, mixed>
     */
    public function resolve(?string $locale = null): array
    {
        $locale ??= app()->getLocale();
        $default = config('locales.default', 'az');

        $data = $this->data ?? [];
        $values = array_filter(
            Arr::get($data, $locale, []),
            fn ($value) => $value !== null && $value !== '' && $value !== []
        );

        if ($locale !== $default) {
            $values += Arr::get($data, $default, []);
        }

        return array_merge($values, $this->resolveShared());
    }

    /**
     * Locale-independent values. Image fields are stored as disk paths and go
     * out as absolute URLs, matching how the other API resources ship media.
     *
     * @return array<string, mixed>
     */
    public function resolveShared(): array
    {
        $shared = $this->shared ?? [];
        if ($shared === []) {
            return [];
        }

        foreach ($this->schema() as $name => $field) {
            $type = $field['type'] ?? null;

            if ($type === 'image' && filled($shared[$name] ?? null)) {
                $shared[$name] = self::url($shared[$name]);
            }

            // A generated set: every value in the map is a stored path.
            if ($type === 'image_set' && is_array($shared[$name] ?? null)) {
                $shared[$name] = array_map(self::url(...), $shared[$name]);
            }
        }

        return array_filter($shared, fn ($value) => $value !== null && $value !== '' && $value !== []);
    }

    /** Stored disk path to a public URL, leaving absolute URLs alone. */
    private static function url(string $path): string
    {
        return str_starts_with($path, 'http')
            ? $path
            : asset('storage/' . ltrim($path, '/'));
    }

    protected static function booted(): void
    {
        // A new favicon source means the derived sizes are stale.
        static::saving(function (self $section) {
            if (! array_key_exists('icons', $section->schema())) {
                return;
            }

            $shared = $section->shared ?? [];
            $source = $shared['favicon'] ?? null;

            $background = $shared['backgroundColor'] ?? '#0d1117';

            $shared['icons'] = filled($source)
                ? IconGenerator::generate($source, (string) $background)
                : [];
            $section->shared = $shared;
        });

        $flush = fn () => ContentCache::flushContent();

        static::saved($flush);
        static::deleted($flush);
    }
}
