<?php

namespace App\Models;

use App\Traits\BelongsToBrand;
use App\Traits\BelongsToUser;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;
use PharIo\Manifest\Email;

class Customer extends Model
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
        'cpf',
        'birthday',
        'mobile',
        'email',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'cep',
        'complement',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'brand_id' => 'integer',
        'birthday' => 'timestamp',
        'active' => 'boolean',
        'user_id' => 'integer',
    ];

    public static function getForm(): array
    {
        return [
            Section::make('Dados Pessoais')
                ->columns(2)
                ->collapsible()
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('cpf')
                        ->label('CPF')
                        ->maxLength(255),
                    DatePicker::make('birthday')
                        ->label('Data de Nascimento'),
                    PhoneNumber::make('mobile')
                        ->label('Celular')
                        ->prefixIcon('heroicon-o-phone')
                        ->maxLength(255),
                    TextInput::make('email')
                        ->prefixIcon('heroicon-o-envelope')
                        ->email(),
                    Toggle::make('active')
                        ->label('Ativo')
                        ->columnSpanFull()
                        ->default(true)
                        ->required(),
                ])
                ->extraAttributes([
                    'style' => 'float: center; '
                ]),
            Section::make('Endereço')
                ->columns(2)
                ->collapsible()
                ->collapsed()
                ->schema([
                    Cep::make('cep')
                        ->label('CEP')
                        ->viaCep(
                            mode: 'suffix',
                            errorMessage: 'CEP inválido.',
                            setFields: [
                                'street' => 'logradouro',
                                'number' => 'numero',
                                'complement' => 'complemento',
                                'neighborhood' => 'bairro',
                                'city' => 'localidade',
                                'state' => 'uf'
                            ]
                        ),
                    TextInput::make('street')
                        ->label('Rua'),
                    TextInput::make('number')
                        ->label('Número'),
                    TextInput::make('neighborhood')
                        ->label('Bairro')
                        ->maxLength(255),
                    Select::make('state')
                        ->options([
                            'AC' => 'Acre',
                            'AL' => 'Alagoas',
                            'AP' => 'Amapá',
                            'AM' => 'Amazonas',
                            'BA' => 'Bahia',
                            'CE' => 'Ceará',
                            'DF' => 'Distrito Federal',
                            'ES' => 'Espírito Santo',
                            'GO' => 'Goiás',
                            'MA' => 'Maranhão',
                            'MT' => 'Mato Grosso',
                            'MS' => 'Mato Grosso do Sul',
                            'MG' => 'Minas Gerais',
                            'PA' => 'Pará',
                            'PB' => 'Paraíba',
                            'PR' => 'Paraná',
                            'PE' => 'Pernambuco',
                            'PI' => 'Piauí',
                            'RJ' => 'Rio de Janeiro',
                            'RN' => 'Rio Grande do Norte',
                            'RS' => 'Rio Grande do Sul',
                            'RO' => 'Rondônia',
                            'RR' => 'Roraima',
                            'SC' => 'Santa Catarina',
                            'SP' => 'São Paulo',
                            'SE' => 'Sergipe',
                            'TO' => 'Tocantins',
                        ]),
                    TextInput::make('city')
                        ->maxLength(255),
                    TextInput::make('complement')
                        ->maxLength(255),
                ]),
        ];
    }

    public static function getColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nome')
                ->searchable(),
            TextColumn::make('cpf')
                ->label('CPF')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('birthday')
                ->label('Data de Nascimento')
                ->date('d/m/Y')
                ->sortable(),
            TextColumn::make('mobile')
                ->label('Celular')
                ->searchable(),
            TextColumn::make('cep')
                ->label('CEP')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('state')
                ->label('Estado')
                ->searchable(),
            TextColumn::make('city')
                ->label('Cidade')
                ->searchable(),
            TextColumn::make('neighborhood')
                ->label('Bairro')
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
            IconColumn::make('active')
                ->label('Ativo')
                ->boolean(),
            // TextColumn::make('last_sale')
            //     ->dateTime()
            //     ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('complement')
                ->label('Complemento')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('user.name')
                ->label('Usuário')
                ->numeric()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
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

    public function customerDependents(): HasMany
    {
        return $this->hasMany(CustomerDependent::class);
    }
}
