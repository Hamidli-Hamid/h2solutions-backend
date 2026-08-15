<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Uploaded clip shown at the top of the detail page; takes
            // precedence over the external link when both are filled in.
            $table->string('video_file')->nullable()->after('gallery');
            // YouTube / Vimeo link, or a direct URL to a hosted video file.
            $table->string('video_url')->nullable()->after('video_file');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['video_file', 'video_url']);
        });
    }
};
