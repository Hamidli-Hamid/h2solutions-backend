<?php

namespace App\Models;

use App\Models\Concerns\HasSeo;
use App\Support\ContentCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * One row per addressable surface of the site. `group` says what the row is:
 *
 *  - `layout`   — copy that appears on every page (header, footer, shared labels)
 *  - `page`     — a real route, e.g. /about
 *  - `template` — the SEO defaults of a dynamic route, e.g. /services/{slug}
 *
 * A new page needs a row and its sections; no PHP or TypeScript changes.
 */
class Page extends Model
{
    use HasSeo;
    use HasTranslations;

    /** @var array<int, string> */
    public array $translatable = [];

    protected $fillable = [
        'key',
        'group',
        'label',
        'path',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    public function scopeOfGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    protected static function booted(): void
    {
        $flush = fn () => ContentCache::flushContent();

        static::saved($flush);
        static::deleted($flush);
    }
}
