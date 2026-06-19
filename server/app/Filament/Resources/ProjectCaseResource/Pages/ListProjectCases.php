<?php

namespace App\Filament\Resources\ProjectCaseResource\Pages;

use App\Filament\Resources\ProjectCaseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectCases extends ListRecords
{
    protected static string $resource = ProjectCaseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
