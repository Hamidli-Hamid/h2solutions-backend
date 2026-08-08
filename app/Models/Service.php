<?php

namespace App\Models;

use App\Models\Concerns\HasSeo;
use App\Support\ContentCache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasSeo;
    use HasTranslations;

    /** @var array<int, string> */
    public array $translatable = ['title', 'summary', 'description', 'features'];

    protected $fillable = [
        'slug',
        'icon',
        'title',
        'summary',
        'description',
        'features',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    protected static function booted(): void
    {
        $flush = fn (self $model) => ContentCache::flushEntity('services', 'service', $model->slug);

        static::saved($flush);
        static::deleted($flush);
    }
}
