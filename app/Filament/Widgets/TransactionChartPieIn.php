<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

class TransactionChartPieIn extends ChartWidget
{
    protected static ?string $heading = 'Receitas por Categoria';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        match ($activeFilter) {
            'today' => $activeFilter = [
                'startDate' => now()->startOfDay(),
                'endDate' => now()->endOfDay(),
            ],
            'week' => $activeFilter = [
                'startDate' => now()->startOfWeek(),
                'endDate' => now()->endOfWeek(),
            ],
            'month' => $activeFilter = [
                'startDate' => now()->startOfMonth(),
                'endDate' => now()->endOfMonth(),
            ],
            'year' => $activeFilter = [
                'startDate' => now()->startOfYear(),
                'endDate' => now()->endOfYear(),
            ],
            default => $activeFilter = [],
        };

        $transaction = Transaction::query()
            ->selectRaw('categories.name as category, sum(transactions.value) as aggregate')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.type', 'in')
            ->whereBetween('transactions.created_at', [
                $activeFilter['startDate'] ?? now()->subMonth(),
                $activeFilter['endDate'] ?? now(),
            ])
            ->groupBy('categories.name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts',
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
