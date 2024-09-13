<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\Support\Htmlable;

class TransactionChartPieOut extends ChartWidget
{
    use InteractsWithPageFilters;

    public function getHeading(): string | Htmlable | null
    {
        return __('labels.expenses_by_category');
    }

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $category = $this->filters['category_id'] ?? null;

        $transaction = Transaction::query()
            ->selectRaw('categories.name as category, sum(transactions.value) as aggregate')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.type', 'out')
            ->whereBetween('transactions.created_at', [
                $activeFilter['startDate'] ?? now()->subMonth(),
                $activeFilter['endDate'] ?? now(),
            ])
            ->when($category, fn($query) => $query->where('transactions.category_id', $category))
            ->groupBy('categories.name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Expenses',
                    'data' => $transaction->map(function ($transaction) {
                        return $transaction->aggregate;
                    }),
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#FFCD56',
                        '#4BC0C0',
                        '#36A2EB',
                        '#9966FF',
                        '#FF9F40',
                        '#FFCE56',
                        '#FF6384',
                    ],
                ],
            ],
            'labels' => $transaction->map(function ($transaction) {
                return $transaction->category;
            }),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
