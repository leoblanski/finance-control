<?php

namespace App\Filament\Actions;

use App\Models\Transaction;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;

class CreateTransaction extends CreateAction
{
    public static function get()
    {
        return CreateAction::make()
            ->label(__('labels.create_transaction'))
            ->slideOver()
            ->model(Transaction::class)
            ->form(
                Transaction::getForm()
            )
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

                    if ($record->category->limit > 0 && abs($totalMonthCategory[0]->aggregate) > abs($record->category->limit)) {
                        Notification::make()
                            ->title('Atenção!')
                            ->body('Você atingiu o limite de gastos da categoria ' . $record->category->name)
                            ->danger()
                            ->seconds(10)
                            ->send();
                    }
                }
            });
    }
}
