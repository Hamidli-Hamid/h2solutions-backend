<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            // Stable identifier the frontend asks for, e.g. `home`, `about`,
            // `service-detail`. Never shown to visitors.
            $table->string('key')->unique();
            // `layout` = header/footer/global copy, `page` = a real route,
            // `template` = the SEO defaults of a dynamic detail route.
            $table->string('group')->default('page')->index();
            $table->string('label');
            // Route pattern under /{locale}, e.g. `/about` or `/services/{slug}`.
            $table->string('path')->nullable();

            // SEO — translatable JSON, same convention as the content models.
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('robots_index')->default(true);
            $table->boolean('robots_follow')->default(true);

            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
