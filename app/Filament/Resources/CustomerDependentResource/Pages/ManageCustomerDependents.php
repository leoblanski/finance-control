<?php

namespace App\Filament\Resources\CustomerDependentResource\Pages;

use App\Filament\Resources\CustomerDependentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCustomerDependents extends ManageRecords
{
    protected static string $resource = CustomerDependentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
