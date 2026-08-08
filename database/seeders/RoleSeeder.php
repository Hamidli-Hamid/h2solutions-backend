<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Permissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * The roles a site starts with. Re-running only fills gaps: an administrator
 * who has since adjusted a role's grants keeps their changes.
 */
class RoleSeeder extends Seeder
{
    /**
     * Role => the subjects it may work with, and how far.
     *
     * @var array<string, array<string, array<int, string>>>
     */
    private array $roles = [
        // Writes and publishes content, but does not manage accounts.
        'editor' => [
            'pages' => ['view', 'update'],
            'services' => ['view', 'create', 'update', 'delete'],
            'projects' => ['view', 'create', 'update', 'delete'],
            'blog_posts' => ['view', 'create', 'update', 'delete'],
            'leads' => ['view', 'update'],
        ],
        // Translates existing content; cannot add or remove anything.
        'translator' => [
            'pages' => ['view', 'update'],
            'services' => ['view', 'update'],
            'projects' => ['view', 'update'],
            'blog_posts' => ['view', 'update'],
        ],
        // Reads the admin without changing anything.
        'viewer' => [
            'pages' => ['view'],
            'services' => ['view'],
            'projects' => ['view'],
            'blog_posts' => ['view'],
            'leads' => ['view'],
        ],
    ];

    public function run(): void
    {
        Permissions::sync();

        $superAdmin = Role::firstOrCreate(['name' => Permissions::SUPER_ADMIN, 'guard_name' => 'web']);

        foreach ($this->roles as $name => $grants) {
            $role = Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);

            // Only a brand-new role gets the defaults; an existing one has
            // already been tuned by someone.
            if ($role->wasRecentlyCreated) {
                $role->syncPermissions($this->permissionNames($grants));
            }
        }

        // Nobody may be left without a way back in: accounts that predate
        // roles become super-admins.
        User::doesntHave('roles')->each(fn (User $user) => $user->assignRole($superAdmin));
    }

    /**
     * @param  array<string, array<int, string>>  $grants
     * @return array<int, string>
     */
    private function permissionNames(array $grants): array
    {
        $names = [];

        foreach ($grants as $subject => $abilities) {
            foreach ($abilities as $ability) {
                $names[] = "$subject.$ability";
            }
        }

        return $names;
    }
}
