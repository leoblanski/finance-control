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
        $startDate = $this->filters['startDate'] ?? now()->subMonth();
        $endDate = $this->filters['endDate'] ?? now();
        $category = $this->filters['category_id'] ?? null;

        $query = Transaction::query()
            ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
            ->when($category, fn(Builder $query) => $query->where('category_id', $category));

        $daysIn = clone $query;
        $daysIn = $daysIn->selectRaw('count(*) as value, date(created_at) as date')
            ->where('value', '>', 0)
            ->groupBy('date')
            ->get();

        $daysOut = clone $query;
        $daysOut = $daysOut->selectRaw('count(*) as value, date(created_at) as date')
            ->where('value', '<', 0)
            ->groupBy('date')
            ->get();

        $query->selectRaw('sum(value) as total');
        $query->selectRaw('sum(case when value > 0 then value else 0 end) as total_in');
        $query->selectRaw('sum(case when value < 0 then value else 0 end) as total_out');

        $totals = $query->first();

        return [
            Stat::make(
                label: __('labels.total_entries'),
                value: function () use ($totals) {
                    return 'R$ ' . number_format($totals->total_in, 2, ',', '.');
                }
            )
                ->chart($daysIn->pluck('value')->toArray())
                ->color('success')
                ->chartColor('success'),
            Stat::make(
                label: __('labels.total_exits'),
                value: function () use ($totals) {
                    return 'R$ ' . number_format($totals->total_out, 2, ',', '.');
                }
            )
                ->chart($daysOut->pluck('value')->toArray())
                ->color('danger'),
            Stat::make(
                label: __('labels.total'),
                value: function () use ($totals) {
                    return 'R$ ' . number_format($totals->total, 2, ',', '.');
                }
            )->color('primary'),
        ];
    }
}
