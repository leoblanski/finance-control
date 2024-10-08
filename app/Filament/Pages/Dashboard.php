<?php

namespace App\Filament\Pages;

use App\Filament\Actions\CreateTransaction;
use App\Filament\Widgets\TransactionChartPieIn;
use App\Filament\Widgets\TransactionChartPieOut;
use App\Filament\Widgets\TransactionTotalStats;
use App\Models\Category;
use App\Models\Transaction;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected function getHeaderActions(): array
    {
        return [
            CreateTransaction::get(),
        ];
    }

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label(__('labels.start_date'))
                            ->default(now()->subMonth()),
                        DatePicker::make('endDate')
                            ->label(__('labels.end_date'))
                            ->default(now()),
                        Select::make('category_ids')
                            ->label(__('labels.categories'))
                            ->multiple()
                            ->options(fn() => Category::pluck('name', 'id')->toArray())
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
