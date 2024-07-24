<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TransactionChartPieIn;
use App\Filament\Widgets\TransactionChartPieOut;
use App\Filament\Widgets\TransactionTotals;
use App\Filament\Widgets\TransactionTotalStats;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label('Start Date')
                            ->required()
                            ->default(now()->subMonth()),
                        DatePicker::make('endDate')
                            ->label('End Date')
                            ->required()
                            ->default(now()),
                    ])
                    ->columns(3),
            ]);
    }

    public function getWidgets(): array
    {
        return [
            TransactionTotalStats::make(),
            TransactionChartPieOut::make(),
            TransactionChartPieIn::make(),
        ];
    }
}
