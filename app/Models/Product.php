<?php

namespace App\Models;

use App\Traits\BelongsToBrand;
use App\Traits\BelongsToUser;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Leandrocfe\FilamentPtbrFormFields\Money;

class Product extends Model
{
    use HasFactory;
    use BelongsToBrand;
    use BelongsToUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'name',
        'description',
        'reference',
        'user_id',
        'product_brand_id',
        'product_line_id',
        'product_category_id',
        'codebar',
        'active',
        'cost_price',
        'sale_price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'brand_id' => 'integer',
        'user_id' => 'integer',
        'product_brand_id' => 'integer',
        'product_line_id' => 'integer',
        'product_category_id' => 'integer',
        'active' => 'boolean',
    ];

    public static function getForm(): array
    {
        return [
            Group::make()
                ->schema([
                    Section::make('Informações Gerais')
                        ->collapsible()
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nome')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('description')
                                ->label('Descrição')
                                ->maxLength(255),
                            TextInput::make('reference')
                                ->label('Referência')
                                ->maxLength(255),
                            TextInput::make('codebar')
                                ->label('Cód. de Barras')
                                // ->unique()
                                ->maxLength(255),
                            Toggle::make('active')
                                ->label('Ativo')
                                ->columnSpanFull()
                                ->default(true)
                                ->required(),
                        ]),
                    Section::make('Imagens')
                        ->schema([
                            FileUpload::make('image')
                                ->maxFiles(3)
                                ->hiddenLabel(),
                        ])
                        ->collapsible(),
                ])->columnSpan(['lg' => 2]),


            Group::make()
                ->schema([
                    Section::make('Preços')
                        ->collapsible()
                        ->columns(2)
                        ->schema([
                            Money::make('cost_price')
                                ->label('Preço de Custo')
                                ->live(onBlur: true)
                                ->required(),
                            Money::make('sale_price')
                                ->live(onBlur: true)
                                ->label('Preço de Venda')
                                ->required(),
                            // Money::make('markup')
                            //     ->label('Markup')
                            //     ->label('Markup')
                            //     ->disabled()
                            //     // Calculate percentual of markup based on cost and sale price
                            //     ->formatStateUsing(function (Get $get, Set $set) {
                            //         // dd(1);
                            //         return $set('markup', floatval($get('sale_price')) - floatval($get('cost_price')));
                            //     })
                        ]),
                    Section::make('Associações')
                        ->collapsible()
                        ->columns(2)
                        ->schema([
                            Select::make('product_line_id')
                                ->columnSpanFull()
                                ->searchable()
                                ->preload()
                                ->label('Linha')
                                ->relationship('productLine', 'name'),
                            Select::make('product_category_id')
                                ->columnSpanFull()
                                ->preload()
                                ->searchable()
                                ->label('Categoria')
                                ->relationship('productCategory', 'name'),
                            Select::make('product_brand_id')
                                ->columnSpanFull()
                                ->searchable()
                                ->preload()
                                ->label('Marca')
                                ->relationship('productBrand', 'name'),

                        ]),
                ])->columnSpan(['lg' => 1]),


        ];
    }

    public static function getColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nome')
                ->sortable()
                ->searchable(),
            TextColumn::make('description')
                ->label('Descrição')
                ->limit(50)
                ->tooltip(fn (Model $record): ?string => $record->description)
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
            TextColumn::make('reference')
                ->label('Referência')
                ->searchable(),
            TextColumn::make('productBrand.name')
                ->label('Marca')
                ->toggleable(isToggledHiddenByDefault: true)
                ->numeric()
                ->sortable(),
            TextColumn::make('productLine.name')
                ->label('Linha')
                ->numeric()
                ->sortable(),
            TextColumn::make('productCategory.name')
                ->label('Categoria')
                ->numeric()
                ->sortable(),
            TextColumn::make('codebar')
                ->label('Cód. de Barras')
                ->searchable(),
            IconColumn::make('active')
                ->label('Ativo')
                ->boolean(),
            TextColumn::make('cost_price')
                ->label('Preço de Custo')
                ->prefix('R$')
                ->formatStateUsing(fn (Product $product) => str_replace('.', ',', $product->cost_price))
                ->sortable(),
            TextColumn::make('sale_price')
                ->label('Preço de Venda')
                ->prefix('R$')
                ->formatStateUsing(fn (Product $product) => str_replace('.', ',', $product->sale_price))
                ->sortable(),
            TextColumn::make('created_at')
                ->label('Criado em')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->label('Atualizado em')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('user.name')
                ->label('Usuário')
                ->numeric()
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productBrand(): BelongsTo
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function productLine(): BelongsTo
    {
        return $this->belongsTo(ProductLine::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
