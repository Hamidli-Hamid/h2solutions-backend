<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $supported = config('locales.supported', ['az']);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:60'],
            'company' => ['nullable', 'string', 'max:160'],
            'service' => ['nullable', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:5000'],
            'locale' => ['nullable', Rule::in($supported)],
            'source_url' => ['nullable', 'string', 'max:500'],
        ]);

        $lead = Lead::create([
            ...$data,
            'locale' => $data['locale'] ?? app()->getLocale(),
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        return response()->json([
            'ok' => true,
            'id' => $lead->id,
        ], 201);
    }
}
