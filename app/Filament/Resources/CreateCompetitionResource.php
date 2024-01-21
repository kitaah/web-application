<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreateCompetitionResource\Pages\ManageCreateCompetitions;
use App\Models\CreateCompetition;
use Exception;
use Filament\{Actions\StaticAction,
    Forms\Components\Grid,
    Forms\Components\Select,
    Forms\Components\Tabs,
    Forms\Components\Tabs\Tab,
    Forms\Components\TextInput,
    Forms\Form,
    Forms\Set,
    Resources\Resource,
    Support\Enums\Alignment,
    Support\Enums\IconPosition,
    Support\Enums\MaxWidth,
    Tables\Actions\Action,
    Tables\Actions\DeleteAction,
    Tables\Actions\EditAction,
    Tables\Columns\TextColumn,
    Tables\Filters\SelectFilter,
    Tables\Table};
use Illuminate\Support\Str;

class CreateCompetitionResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = CreateCompetition::class;

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Planifications';

    /**
     * Get the singular label for the resource.
     *
     * @var string|null
     */
    protected static ?string $label = 'une planification';

    /**
     * The slug used for this resource.
     *
     * @var string|null
     */
    protected static ?string $slug = 'planifications';

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
    protected static ?string $navigationLabel = 'Planifications';

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
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-arrow-path-rounded-square';

    /**
     * Define the form structure for creating and updating planned competitions.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        /** @var $form */
        return $form
            ->schema(components: [
                Tabs::make('Tabs')
                    ->tabs(tabs: [
                        Tab::make('Identification')
                            ->icon('heroicon-m-tag')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Grid::make('Identification')
                                    ->schema(components: [
                                        TextInput::make('name')
                                            ->label('Nom')
                                            ->placeholder('Nom')
                                            ->required()
                                            ->autofocus()
                                            ->string()
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
                                             */ callback: fn (string $state) => ucfirst(htmlspecialchars($state))),
                                        TextInput::make('slug')
                                            ->placeholder('Slug')
                                            ->required()
                                            ->string()
                                            ->alphaDash()
                                            ->maxLength(50)
                                            ->suffixIcon('heroicon-m-bookmark')
                                            ->suffixIconColor('danger')
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => htmlspecialchars($state)),
                                    ])->columns(),
                            ]),
                        Tab::make('Organisation')
                            ->icon('heroicon-m-arrow-path-rounded-square')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Grid::make('Identification')
                                    ->schema(components: [
                                        Select::make('competition_id')
                                            ->label('Compétition')
                                            ->placeholder('Sélectionnez une compétition')
                                            ->required()
                                            ->regex('/^[0-9]+$/i')
                                            ->relationship('competition', 'identification')
                                            ->suffixIcon('heroicon-m-trophy')
                                            ->suffixIconColor('danger')
                                            ->preload()
                                            ->searchable()
                                            ->searchPrompt('Rechercher un identifiant')
                                            ->loadingMessage('Chargement des identifiants...')
                                            ->noSearchResultsMessage('Aucun identifiant trouvé')
                                            ->selectablePlaceholder(false)
                                            ->optionsLimit(20)
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => htmlspecialchars($state)),
                                        Select::make('association_id')
                                            ->label('Association 1')
                                            ->placeholder('Sélectionnez une association')
                                            ->required()
                                            ->regex('/^[0-9]+$/i')
                                            ->relationship('association', 'name')
                                            ->suffixIcon('heroicon-m-building-storefront')
                                            ->suffixIconColor('danger')
                                            ->preload()
                                            ->searchable()
                                            ->searchPrompt('Rechercher une association')
                                            ->loadingMessage('Chargement des associations...')
                                            ->noSearchResultsMessage('Aucune association trouvée')
                                            ->selectablePlaceholder(false)
                                            ->optionsLimit(20)
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => htmlspecialchars($state)),
                                        Select::make('association_id_second')
                                            ->label('Association 2')
                                            ->placeholder('Sélectionnez une association')
                                            ->required()
                                            ->regex('/^[0-9]+$/i')
                                            ->relationship('association', 'name')
                                            ->suffixIcon('heroicon-m-building-storefront')
                                            ->suffixIconColor('danger')
                                            ->preload()
                                            ->searchable()
                                            ->searchPrompt('Rechercher une association')
                                            ->loadingMessage('Chargement des associations...')
                                            ->noSearchResultsMessage('Aucune association trouvée')
                                            ->selectablePlaceholder(false)
                                            ->optionsLimit(20)
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => htmlspecialchars($state)),
                                        Select::make('association_id_third')
                                            ->label('Association 3')
                                            ->placeholder('Sélectionnez une association')
                                            ->required()
                                            ->regex('/^[0-9]+$/i')
                                            ->relationship('association', 'name')
                                            ->suffixIcon('heroicon-m-building-storefront')
                                            ->suffixIconColor('danger')
                                            ->preload()
                                            ->searchable()
                                            ->searchPrompt('Rechercher une association')
                                            ->loadingMessage('Chargement des associations...')
                                            ->noSearchResultsMessage('Aucune association trouvée')
                                            ->selectablePlaceholder(false)
                                            ->optionsLimit(20)
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => htmlspecialchars($state)),
                                    ])->columns(),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    /**
     * Define the table structure for listing organized competitions
     *
     * @param Table $table
     * @return Table
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
        return $table
            ->heading('Planification des compétitions')
            ->description('Listing, ajout, modification et suppression de planification de compétitions.')
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->icon('heroicon-m-tag')
                    ->iconColor('danger'),
                TextColumn::make('competition.identification')
                    ->label('Compétition')
                    ->icon('heroicon-m-trophy')
                    ->iconColor('danger'),
                TextColumn::make('competition.status')
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
                SelectFilter::make('competition.status')
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
                    ->modalWidth(MaxWidth::ThreeExtraLarge)
                    ->successNotificationTitle('Planification modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer cette planification ?')
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Planification supprimée'),
            ])
            ->searchPlaceholder('Rechercher une planification')
            ->persistSearchInSession()
            ->paginated(condition: [10, 25, 50, 100, 'all']);
    }

    /**
     * Get the pages associated with the resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageCreateCompetitions::route('/'),
        ];
    }
}
