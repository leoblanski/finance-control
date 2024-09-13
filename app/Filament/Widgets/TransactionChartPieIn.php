<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class TransactionChartPieIn extends ChartWidget
{
    public function getHeading(): string | Htmlable | null
    {
        return __('labels.income_by_category');
    }

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $category = $this->filters['category_id'] ?? null;

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
            default => $activeFilter = [
                'startDate' => $startDate ?? now()->subMonth(),
                'endDate' => $endDate ?? now(),
            ],
        };

        $transaction = Transaction::query()
            ->selectRaw('categories.name as category, sum(transactions.value) as aggregate')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.type', 'in')
            ->whereBetween('transactions.created_at', [
                $activeFilter['startDate'] ?? now()->subMonth(),
                $activeFilter['endDate'] ?? now(),
            ])
            ->when($category, fn($query) => $query->where('category_id', $category))
            ->groupBy('categories.name')
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
