<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompetitionResource\Pages\ManageCompetitions;
use App\Models\Competition;
use Filament\{Actions\StaticAction,
    Forms\Components\DatePicker,
    Forms\Components\Grid,
    Forms\Components\Select,
    Forms\Components\TextInput,
    Forms\Form,
    Forms\Set,
    Resources\Resource,
    Support\Enums\Alignment,
    Support\Enums\MaxWidth,
    Tables\Actions\Action,
    Tables\Actions\DeleteAction,
    Tables\Actions\EditAction,
    Tables\Columns\TextColumn,
    Tables\Filters\SelectFilter,
    Tables\Table};
use Exception;
use Illuminate\Support\Str;

class CompetitionResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = Competition::class;

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Compétitions';

    /**
     * Get the singular label for the resource.
     *
     * @var string|null
     */
    protected static ?string $label = 'une compétition';

    /**
     * Navigation group for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Gestion des compétitions';

    /**
     * Navigation label for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationLabel = 'Compétitions';

    /**
     * Navigation sort order for the resource.
     *
     * @var int|null
     */
    protected static ?int $navigationSort = 3;

    /**
     * Navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-trophy';

    /**
     * Define the form structure for creating and updating competitions.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        /** @var $form */
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
                            ->afterStateUpdated(/**
                             * @param Set $set
                             * @param string|null $state
                             * @return mixed
                             */ callback: fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->dehydrateStateUsing(/**
                             * @param string $state
                             * @return string
                             */ callback: fn (string $state) => strtoupper($state)),
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
                            ->dehydrateStateUsing(/**
                             * @param string $state
                             * @return string
                             */ callback: fn (string $state) => htmlspecialchars($state)),
                    ])->columns(),
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
                    ])->columns(),
            ]);
    }

    /**
     * Define the table structure for listing competitions
     *
     * @param Table $table
     * @return Table
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
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
                        'primary' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'Non lancée',
                        'success' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'En cours',
                        'danger' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'Terminée',
                    ])
                    ->icons([
                        'heroicon-s-x-mark' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'Non lancée',
                        'heroicon-s-check' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'En cours',
                        'heroicon-s-bookmark' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'Terminée',
                    ])
                    ->iconPosition('before')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
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
            /**
             * @param Action $action
             * @return Action
             */ callback: fn (Action $action) => $action
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
            /**
             * @param Action $action
             * @return Action
             */ callback: fn (Action $action) => $action
                    ->color('danger')
                    ->label('Filtrer')
                    ->badgeColor('warning'),
            )
            ->actions([
                EditAction::make()
                    ->color('warning')
                    ->button()
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('danger'))
                    ->modalAlignment(Alignment::Center)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->modalWidth(MaxWidth::TwoExtraLarge)
                    ->successNotificationTitle('Compétition modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer cette compétition ?')
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Compétition supprimée'),
            ])
            ->searchPlaceholder('Rechercher une compétition')
            ->persistSearchInSession()
            ->paginated([10, 25, 50, 100, 'all']);
    }

    /**
     * Get the pages associated with the resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageCompetitions::route('/'),
        ];
    }

    /**
     * Get the plural label for the resource.
     *
     * @return string
     */
    public static function getPluralLabel(): string
    {
        return __(/** @lang text */ 'Compétitions');
    }

    /**
     * Get the singular label for the resource.
     *
     * @return string
     */
    public static function getLabel(): string
    {
        return __(/** @lang text */ 'une compétition');
    }
}
