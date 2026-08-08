<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The same SEO overrides every content model needs. Columns instead of a
 * separate polymorphic table: the three detail endpoints already ship their
 * record to the frontend, so the meta travels with it for free.
 */
return new class extends Migration
{
    /** @var array<int, string> */
    private array $tables = ['services', 'projects', 'blog_posts'];

    public function up(): void
    {
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->json('seo_title')->nullable();
                $table->json('seo_description')->nullable();
                $table->string('og_image')->nullable();
                $table->boolean('robots_index')->default(true);
                $table->boolean('robots_follow')->default(true);
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropColumn([
                    'seo_title',
                    'seo_description',
                    'og_image',
                    'robots_index',
                    'robots_follow',
                ]);
            });
        }
    }
};
