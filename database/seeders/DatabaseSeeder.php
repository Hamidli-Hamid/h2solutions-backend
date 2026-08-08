<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ContentSeeder::class,
            ServiceSeeder::class,
            ProjectSeeder::class,
            BlogPostSeeder::class,
        ]);
    }
}
