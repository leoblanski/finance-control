<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class TransactionTotalStats extends BaseWidget
{
    use InteractsWithPageFilters;

    public function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        return [
            Stat::make(
                label: 'Total entradas',
                value: function () use ($startDate, $endDate) {
                    $total = Transaction::query()
                        ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                        ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                        ->where('value', '>', 0)
                        ->sum('value');

                    return 'R$ ' . number_format($total, 2, ',', '.');
                }
            )
                ->chart([1, 1, 1, 1])
                ->color('success')
                ->chartColor('success'),
            Stat::make(
                label: 'Total saídas',
                value: function () use ($startDate, $endDate) {
                    $total = Transaction::query()
                        ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                        ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                        ->where('value', '<', 0)
                        ->sum('value');

                    return 'R$ ' . number_format($total, 2, ',', '.');
                }
            )
                ->chart([1, 1, 1, 1])
                ->color('danger'),
            Stat::make(
                label: 'Saldo',
                value: function () use ($startDate, $endDate) {
                    $total = Transaction::query()
                        ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                        ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                        ->sum('value');

                    return 'R$ ' . number_format($total, 2, ',', '.');
                }
            )->color('primary'),
        ];
    }
}
