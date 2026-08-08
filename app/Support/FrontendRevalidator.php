<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Tells the Next.js site to drop its cached copy of the content after an edit,
 * so the change is live immediately instead of after the revalidation window.
 *
 * Best effort by design: the site stays correct without it (it re-fetches on
 * its own schedule), so a slow or missing frontend must never fail a save.
 */
class FrontendRevalidator
{
    public static function ping(): void
    {
        $url = rtrim((string) config('services.frontend.url'), '/');
        $secret = (string) config('services.frontend.revalidate_secret');

        if ($url === '' || $secret === '') {
            return;
        }

        try {
            $response = Http::withHeaders(['x-revalidate-secret' => $secret])
                ->timeout(3)
                ->post("$url/api/revalidate");

            if ($response->failed()) {
                Log::warning('Frontend revalidation refused', [
                    'status' => $response->status(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('Frontend revalidation failed: ' . $e->getMessage());
        }
    }
}
