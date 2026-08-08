<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Cache::remember(
            'api.projects.' . app()->getLocale(),
            now()->addMinutes(15),
            fn () => Project::published()->orderBy('sort_order')->get()
        );

        return ProjectResource::collection($projects);
    }

    public function show(string $slug)
    {
        $project = Cache::remember(
            "api.project.{$slug}." . app()->getLocale(),
            now()->addMinutes(15),
            fn () => Project::published()->where('slug', $slug)->firstOrFail()
        );

        return new ProjectResource($project);
    }
}
