<?php

namespace App\Filament\Resources\RoleResource\Concerns;

use App\Support\Permissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * The role form shows one checkbox group per subject for readability; the role
 * itself holds a single flat list. This translates between the two.
 */
trait SyncsPermissionGroups
{
    /** Ticked boxes across all groups, flattened. */
    protected function selectedPermissions(array $data): array
    {
        return array_values(array_unique(Arr::flatten($data['permission_groups'] ?? [])));
    }

    /** Spread a flat permission list back across the groups. */
    protected function fillPermissionGroups(array $data, array $permissions): array
    {
        foreach (Permissions::grouped() as $label => $options) {
            $data['permission_groups'][Str::slug($label)] = array_values(
                array_intersect(array_keys($options), $permissions)
            );
        }

        return $data;
    }

    /** The groups are a form-only construct — never a column. */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->permissionSelection = $this->selectedPermissions($data);

        return Arr::except($data, 'permission_groups');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->permissionSelection = $this->selectedPermissions($data);

        return Arr::except($data, 'permission_groups');
    }

    protected function afterCreate(): void
    {
        $this->syncPermissionSelection($this->getRecord());
    }

    protected function afterSave(): void
    {
        $this->syncPermissionSelection($this->getRecord());
    }

    private function syncPermissionSelection(Model $role): void
    {
        // Super-admin passes every check by rule; storing grants would only
        // drift from that.
        if ($role->name === Permissions::SUPER_ADMIN) {
            return;
        }

        $role->syncPermissions($this->permissionSelection ?? []);
    }

    /** @var array<int, string> */
    public array $permissionSelection = [];
}
