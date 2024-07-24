<?php

namespace App\Filament\Resources\TransactionResource\Pages;

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
            Actions\CreateAction::make()->slideOver()
                ->mutateFormDataUsing(function (array $data): array {
                    $type = $data['type'] ?? null;

                    if ($type == 'out') {
                        $data['value'] = -$data['value'];
                    }

                    return $data;
                })
                ->after(function ($record) {
                    if ($record->type == 'out' && $record->category->limit != null) {
                        $totalMonthCategory = Transaction::query()
                            ->selectRaw('sum(transactions.value) as aggregate')
                            ->join('categories', 'transactions.category_id', '=', 'categories.id')
                            ->where('transactions.type', 'out')
                            ->where('transactions.category_id', $record->category_id)
                            ->whereBetween('transactions.created_at', [
                                now()->startOfMonth(),
                                now()->endOfMonth(),
                            ])
                            ->groupBy('categories.name')
                            ->get();

                        if (abs($totalMonthCategory[0]->aggregate) > abs($record->category->limit)) {
                            Notification::make()
                                ->title('Atenção!')
                                ->body('Você atingiu o limite de gastos da categoria ' . $record->category->name)
                                ->danger()
                                ->seconds(10)
                                ->send();
                        }
                    }
                }),
        ];
    }
}
