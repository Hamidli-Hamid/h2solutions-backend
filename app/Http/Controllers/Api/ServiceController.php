<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Cache::remember(
            'api.services.' . app()->getLocale(),
            now()->addMinutes(15),
            fn () => Service::published()->orderBy('sort_order')->get()
        );

        return ServiceResource::collection($services);
    }

    public function show(string $slug)
    {
        $service = Cache::remember(
            "api.service.{$slug}." . app()->getLocale(),
            now()->addMinutes(15),
            fn () => Service::published()->where('slug', $slug)->firstOrFail()
        );

        return new ServiceResource($service);
    }
}
