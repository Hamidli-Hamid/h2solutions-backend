<?php

use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Middleware\SetApiLocale;
use Illuminate\Support\Facades\Route;

Route::middleware(SetApiLocale::class)->group(function () {
    Route::get('/locales', fn () => response()->json([
        'default' => config('locales.default'),
        'supported' => config('locales.supported'),
        'current' => app()->getLocale(),
    ]));

    // Every editable string and per-page meta override, for one language.
    Route::get('/content', [ContentController::class, 'index']);

    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{slug}', [ServiceController::class, 'show']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{slug}', [ProjectController::class, 'show']);

    Route::get('/blog', [BlogPostController::class, 'index']);
    Route::get('/blog/{slug}', [BlogPostController::class, 'show']);

    Route::post('/leads', [LeadController::class, 'store'])
        ->middleware('throttle:10,1');
});
