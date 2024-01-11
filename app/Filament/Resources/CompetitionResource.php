<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompetitionResource\Pages\ManageCompetitions;
use App\Models\Competition;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CompetitionResource extends Resource
{
    protected static ?string $model = Competition::class;

    protected static ?string $navigationGroup = 'Gestion des compétitions';

    protected static ?string $navigationLabel = 'Compétitions';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $activeNavigationIcon = 'heroicon-s-trophy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(components: [
                Grid::make('Identification')
                    ->schema(components: [
                        TextInput::make('identification')
                            ->label('Identifiant')
                            ->placeholder('Identifiant')
                            ->required()
                            ->string()
                            ->regex('/^[A-Za-z0-9]+$/i')
                            ->autofocus()
                            ->maxLength(50)
                            ->suffixIcon('heroicon-m-tag')
                            ->suffixIconColor('danger')
                            ->unique(ignoreRecord: true)
                            ->live(debounce: 250)
                            ->debounce(250)
                            ->afterStateUpdated(callback: fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->dehydrateStateUsing(callback: fn (string $state) => strtoupper($state)),
                        TextInput::make('slug')
                            ->required()
                            ->placeholder('Slug')
                            ->string()
                            ->alphaDash()
                            ->maxLength(50)
                            ->suffixIcon('heroicon-m-bookmark')
                            ->suffixIconColor('danger')
                            ->unique(ignoreRecord: true),
                        TextInput::make('budget')
                            ->placeholder('Budget')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(1000000)
                            ->suffixIcon('heroicon-m-currency-dollar')
                            ->suffixIconColor('danger'),
                        Select::make('status')
                            ->label('Statut')
                            ->required()
                            ->placeholder('Sélectionnez un statut')
                            ->options([
                                'Non lancée' => 'Non lancée',
                                'En cours' => 'En cours',
                                'Terminée' => 'Terminée',
                            ])
                            ->suffixIcon('heroicon-m-information-circle')
                            ->suffixIconColor('danger')
                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                    ])->columns(2),
                Grid::make('Start and end date')
                    ->schema(components: [
                        DatePicker::make('start_date')
                            ->label('Date de début')
                            ->date()
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Date de fin')
                            ->date()
                            ->required(),
                    ])->columns(2),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->heading('Gestion des compétitions')
            ->description('Listing, ajout, modification et suppression de compétitions.')
            ->columns(components: [
                TextColumn::make('identification')
                    ->label('Identifiant')
                    ->searchable()
                    ->icon('heroicon-m-tag')
                    ->iconColor('danger'),
                TextColumn::make('budget')
                    ->numeric()
                    ->icon('heroicon-m-currency-dollar')
                    ->iconColor('danger')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->alignCenter()
                    ->colors([
                        'primary' => static fn ($state): bool => $state === 'Non lancée',
                        'success' => static fn ($state): bool => $state === 'En cours',
                        'danger' => static fn ($state): bool => $state === 'Terminée',
                    ])
                    ->icons([
                        'heroicon-s-x-mark' => static fn ($state): bool => $state === 'Non lancée',
                        'heroicon-s-check' => static fn ($state): bool => $state === 'En cours',
                        'heroicon-s-bookmark' => static fn ($state): bool => $state === 'Terminée',
                    ])
                    ->iconPosition('before')
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('slug')
                    ->searchable()
                    ->icon('heroicon-m-bookmark')
                    ->iconColor('danger')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('start_date')
                    ->label('Date de création')
                    ->icon('heroicon-m-clock')
                    ->iconColor('danger')
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('end_date')
                    ->label('Date de fin')
                    ->icon('heroicon-m-clock')
                    ->iconColor('danger')
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Création')
                    ->icon('heroicon-m-clock')
                    ->iconColor('danger')
                    ->dateTime('d-m-Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Mise à jour')
                    ->icon('heroicon-m-clock')
                    ->iconColor('danger')
                    ->dateTime('d-m-Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->toggleColumnsTriggerAction(
                callback: fn (Action $action) => $action
                    ->color('info')
                    ->label('Ajouter des colonnes'),
            )
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'Non lancée' => 'Non lancée',
                        'En cours' => 'En cours',
                        'Terminée' => 'Terminée',
                    ]),
            ])
            ->filtersTriggerAction(
                callback: fn (Action $action) => $action
                    ->color('danger')
                    ->label('Filtrer')
                    ->badgeColor('warning'),
            )
            ->actions([
                EditAction::make()
                    ->color('warning')
                    ->button()
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('danger'))
                    ->modalAlignment(Alignment::Center)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->modalWidth(MaxWidth::TwoExtraLarge)
                    ->successNotificationTitle('Compétition modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sur de vouloir supprimer cette compétition ?')
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Compétition supprimée'),
            ])
            ->searchPlaceholder('Rechercher une compétition')
            ->persistSearchInSession()
            ->paginated([10, 25, 50, 100, 'all']);
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageCompetitions::route('/'),
        ];
    }

    public static function getPluralLabel(): string
    {
        return __('Compétitions');
    }

    public static function getLabel(): string
    {
        return __('une compétition');
    }
}
