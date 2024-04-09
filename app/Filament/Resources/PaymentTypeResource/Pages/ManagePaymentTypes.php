<?php

namespace App\Filament\Resources\PaymentTypeResource\Pages;

use App\Filament\Resources\PaymentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePaymentTypes extends ManageRecords
{
    protected static string $resource = PaymentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
