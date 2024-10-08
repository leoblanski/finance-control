<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\Support\Htmlable;

class TransactionChartPieIn extends ChartWidget
{
    use InteractsWithPageFilters;

    public function getHeading(): string | Htmlable | null
    {
        return __('labels.income_by_category');
    }

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? now()->subMonth();
        $endDate = $this->filters['endDate'] ?? now();
        $categoryIds = $this->filters['category_id'] ?? null;

        $transaction = Transaction::query()
            ->selectRaw('categories.name as category, sum(transactions.value) as aggregate')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->where('transactions.value', '>', 0)
            ->whereBetween('transactions.date', [
                $startDate,
                $endDate,
            ])
            ->when($categoryIds, fn($query) => $query->whereIn('category_id', $categoryIds))
            ->groupBy('categories.name', 'users.name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Income',
                    'data' => $transaction->map(function ($transaction) {
                        return $transaction->aggregate;
                    }),
                    'backgroundColor' => [
                        '#4BC0C0',
                        '#FF6384',
                        '#FFCE56',
                        '#FF9F40',
                        '#FFCD56',
                        '#FF6384',
                        '#36A2EB',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#FFCE56',
                        '#FF6384',
                        '#36A2EB',
                        '#4BC0C0',


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
