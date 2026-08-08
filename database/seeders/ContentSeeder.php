<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Pages and sections come from the frontend dictionaries — see
 * App\Console\Commands\ImportContentDictionaries. Existing rows are left alone,
 * so seeding a live database never discards an editor's work.
 */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('content:import', [], $this->command?->getOutput());
    }
}
