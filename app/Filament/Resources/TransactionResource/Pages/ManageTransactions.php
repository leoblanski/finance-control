<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Actions\CreateTransaction;
use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageTransactions extends ManageRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateTransaction::get(),
        ];
    }
}
