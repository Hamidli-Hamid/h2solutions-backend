<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Filament\Resources\RoleResource\Concerns\SyncsPermissionGroups;
use App\Support\Permissions;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    use SyncsPermissionGroups;

    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(fn () => $this->getRecord()->name === Permissions::SUPER_ADMIN),
        ];
    }

    /** Spread the role's permissions across the per-subject checkbox groups. */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->fillPermissionGroups($data, $this->getRecord()->permissions->pluck('name')->all());
    }
}
