<?php

namespace App\Filament\Resources\DependentTypeResource\Pages;

use App\Filament\Resources\DependentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDependentTypes extends ManageRecords
{
    protected static string $resource = DependentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
