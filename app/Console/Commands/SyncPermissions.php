<?php

namespace App\Console\Commands;

use App\Support\Permissions;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

/**
 * Brings the permission rows in line with the catalogue in App\Support\
 * Permissions, and makes sure the super-admin role exists. Run it after adding
 * a subject; existing roles and their grants are left untouched.
 */
class SyncPermissions extends Command
{
    protected $signature = 'permissions:sync';

    protected $description = 'Create any missing permissions and the super-admin role';

    public function handle(): int
    {
        $created = Permissions::sync();

        $role = Role::firstOrCreate(['name' => Permissions::SUPER_ADMIN, 'guard_name' => 'web']);

        $this->info("Permissions synced — $created new, role [{$role->name}] ready.");

        return self::SUCCESS;
    }
}
