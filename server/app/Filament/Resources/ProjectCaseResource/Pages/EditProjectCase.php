<?php

namespace App\Filament\Resources\ProjectCaseResource\Pages;

use App\Filament\Resources\ProjectCaseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectCase extends EditRecord
{
    protected static string $resource = ProjectCaseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
