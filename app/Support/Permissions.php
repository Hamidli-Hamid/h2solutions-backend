<?php

namespace App\Support;

use Spatie\Permission\Models\Permission;

/**
 * The permission catalogue: one subject per thing an editor works on, times
 * the four things they can do with it.
 *
 * Names are `<subject>.<ability>`, e.g. `pages.update`. Adding a subject here
 * and running `php artisan permissions:sync` is all a new admin area needs —
 * the role form lists it automatically.
 */
class Permissions
{
    public const ABILITIES = ['view', 'create', 'update', 'delete'];

    /** Role that is allowed everything, including future permissions. */
    public const SUPER_ADMIN = 'super-admin';

    /**
     * Subject key => label shown in the role form.
     *
     * @return array<string, string>
     */
    public static function subjects(): array
    {
        return [
            'pages' => 'Pages & sections',
            'services' => 'Services',
            'projects' => 'Projects',
            'blog_posts' => 'Blog posts',
            'leads' => 'Leads',
            'users' => 'Users',
            'roles' => 'Roles & permissions',
        ];
    }

    /**
     * Every permission name in the catalogue.
     *
     * @return array<int, string>
     */
    public static function all(): array
    {
        $names = [];

        foreach (array_keys(self::subjects()) as $subject) {
            foreach (self::ABILITIES as $ability) {
                $names[] = "$subject.$ability";
            }
        }

        return $names;
    }

    /**
     * Permission names grouped by subject label — the shape the role form
     * renders as one checkbox group per subject.
     *
     * @return array<string, array<string, string>>
     */
    public static function grouped(): array
    {
        $groups = [];

        foreach (self::subjects() as $subject => $label) {
            $options = [];

            foreach (self::ABILITIES as $ability) {
                $options["$subject.$ability"] = ucfirst($ability);
            }

            $groups[$label] = $options;
        }

        return $groups;
    }

    /** Create any permission that does not exist yet. Safe to re-run. */
    public static function sync(string $guard = 'web'): int
    {
        $existing = Permission::where('guard_name', $guard)->pluck('name')->all();
        $missing = array_diff(self::all(), $existing);

        foreach ($missing as $name) {
            Permission::create(['name' => $name, 'guard_name' => $guard]);
        }

        return count($missing);
    }
}
