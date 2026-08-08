<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();

            // Dotted path this section fills in the content tree the frontend
            // consumes, e.g. `home.faq` or `about.founder`. Unique site-wide:
            // the page is only how the section is filed in the admin.
            $table->string('key')->unique();
            // Field schema to render — see config/sections.php.
            $table->string('type')->index();

            // Editable content keyed by locale: {"az": {...}, "en": {...}}.
            // A plain JSON cast rather than spatie/translatable because the
            // value is a nested structure, not a single translated string.
            $table->json('data')->nullable();
            // Locale-independent values (image paths, URLs, switches).
            $table->json('shared')->nullable();

            $table->boolean('is_visible')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
