<?php

namespace App\Models;

use App\Models\Concerns\HasSeo;
use App\Support\ContentCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasSeo;
    use HasTranslations;

    /** @var array<int, string> */
    public array $translatable = ['title', 'excerpt', 'content'];

    protected $fillable = [
        'slug',
        'author_id',
        'cover_image',
        'title',
        'excerpt',
        'content',
        'read_minutes',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'read_minutes' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    protected static function booted(): void
    {
        $flush = fn (self $model) => ContentCache::flushEntity('blog', 'blog', $model->slug);

        static::saved($flush);
        static::deleted($flush);
    }
}
