<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Layout and template rows are wired into the frontend by key;
            // deleting them would leave the site without that copy.
            Actions\DeleteAction::make()
                ->visible(fn () => $this->getRecord()->group === 'page'),
        ];
    }
}
