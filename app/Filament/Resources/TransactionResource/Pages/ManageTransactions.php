<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTransactions extends ManageRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver()
                ->mutateFormDataUsing(function (array $data): array {
                    $type = $data['type'] ?? null;

                    if ($type == 'out') {
                        $data['value'] = -$data['value'];
                    }

                    return $data;
                }),
        ];
    }
}
