<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The project story used to be three separate fields (problem / solution /
 * result). It is now one rich-text body, so the old copy is merged into it
 * paragraph by paragraph and the legacy columns are kept — nullable and no
 * longer edited — in case the original split is ever needed again.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('body')->nullable()->after('summary');
        });

        foreach (DB::table('projects')->get(['id', 'problem', 'solution', 'result']) as $row) {
            $blocks = collect(['problem', 'solution', 'result'])
                ->map(fn (string $key) => json_decode($row->{$key} ?? '{}', true) ?: []);

            $locales = $blocks->flatMap(fn (array $translations) => array_keys($translations))
                ->unique();

            $body = $locales
                ->mapWithKeys(function (string $locale) use ($blocks) {
                    $html = $blocks
                        ->map(fn (array $translations) => trim((string) ($translations[$locale] ?? '')))
                        ->filter()
                        // Blank lines in the old textareas were paragraph breaks.
                        ->flatMap(fn (string $text) => preg_split('/\R{2,}/', $text))
                        ->map(fn (string $paragraph) => trim($paragraph))
                        ->filter()
                        ->map(fn (string $paragraph) => '<p>'.e($paragraph).'</p>')
                        ->implode('');

                    return [$locale => $html];
                })
                ->filter();

            DB::table('projects')
                ->where('id', $row->id)
                ->update(['body' => json_encode($body->all(), JSON_UNESCAPED_UNICODE)]);
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->json('problem')->nullable()->change();
            $table->json('solution')->nullable()->change();
            $table->json('result')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('body');
        });
    }
};
