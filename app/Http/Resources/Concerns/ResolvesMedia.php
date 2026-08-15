<?php

namespace App\Http\Resources\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Uploads are stored as disk-relative paths; the frontend needs an absolute
 * URL it can hand to next/image.
 */
trait ResolvesMedia
{
    protected function imageUrl(?string $path): ?string
    {
        return $this->mediaUrl($path);
    }

    /** Same resolution for non-image uploads (video files, documents). */
    protected function mediaUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return url(Storage::disk('public')->url($path));
    }
}
