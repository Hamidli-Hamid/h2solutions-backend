<?php

namespace App\Models;

use App\Models\Concerns\HasSeo;
use App\Support\ContentCache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasSeo;
    use HasTranslations;

    /**
     * `problem`, `solution` and `result` are legacy — their copy now lives in
     * `body`; they stay declared so old rows remain readable.
     *
     * @var array<int, string>
     */
    public array $translatable = ['title', 'summary', 'body', 'problem', 'solution', 'result'];

    protected $fillable = [
        'slug',
        'client',
        'year',
        'url',
        'cover_image',
        'gallery',
        'video_file',
        'video_url',
        'title',
        'summary',
        'body',
        'problem',
        'solution',
        'result',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'year' => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    protected static function booted(): void
    {
        $flush = fn (self $model) => ContentCache::flushEntity('projects', 'project', $model->slug);

        static::saved($flush);
        static::deleted($flush);
    }
}
