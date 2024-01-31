<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssociationResource\Pages\ManageAssociations;
use App\Models\Association;
use App\Models\Statistic;
use Exception;
use Filament\{Actions\StaticAction,
    Forms\Components\Grid,
    Forms\Components\Hidden,
    Forms\Components\Select,
    Forms\Components\SpatieMediaLibraryFileUpload,
    Forms\Components\Tabs,
    Forms\Components\Tabs\Tab,
    Forms\Components\Textarea,
    Forms\Components\TextInput,
    Forms\Components\Toggle,
    Forms\Form,
    Forms\Set,
    Resources\Resource,
    Support\Enums\Alignment,
    Support\Enums\IconPosition,
    Tables\Actions\Action,
    Tables\Actions\DeleteAction,
    Tables\Actions\EditAction,
    Tables\Columns\IconColumn,
    Tables\Columns\TextColumn,
    Tables\Filters\TernaryFilter,
    Tables\Table};
use Illuminate\{Database\Eloquent\Builder, Support\Collection, Support\Str};
use JsonException;

class AssociationResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = Association::class;

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Associations';

    /**
     * Get the singular label for the resource.
     *
     * @var string|null
     */
    protected static ?string $label = 'une association';

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
    protected static ?string $navigationLabel = 'Associations';

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
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-building-storefront';

    /**
     * Define the form structure for creating and updating associations.
     *
     * @param Form $form
     * @return Form
     * @throws JsonException
     */
    public static function form(Form $form): Form
    {
        $association = new Association();
        $cities = $association->fetchCitiesFromAPI();
        $cityOptions = $cities->pluck('label', 'id')->toArray();

        /** @var $form */
        return $form
            ->schema(components: [
                Hidden::make('points')
                    ->regex('/^[0-9]+$/i')
                    ->default(0),
                Tabs::make('Tabs')
                    ->tabs(tabs: [
                        Tab::make('Informations générales')
                            ->icon('heroicon-m-tag')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Grid::make('Name and slug')
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
                                             */ callback: fn (string $state) => trim(htmlspecialchars($state, ENT_COMPAT))),
                                        TextInput::make('slug')
                                            ->placeholder('Slug')
                                            ->required()
                                            ->string()
                                            ->maxLength(50)
                                            ->suffixIcon('heroicon-m-bookmark')
                                            ->suffixIconColor('danger')
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => trim(htmlspecialchars($state))),
                                    ])->columns(2),
                                Grid::make('SIRET and city')
                                    ->schema(components: [
                                        TextInput::make('siret')
                                            ->placeholder('SIRET')
                                            ->required()
                                            ->string()
                                            ->regex('/^[0-9]+$/i')
                                            ->length(14)
                                            ->suffixIcon('heroicon-m-identification')
                                            ->suffixIconColor('danger')
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => trim(htmlspecialchars($state))),
                                        Select::make('city')
                                            ->label('Ville')
                                            ->placeholder('Sélectionnez une ville')
                                            ->required()
                                            ->preload()
                                            ->options($cityOptions)
                                            ->suffixIcon('heroicon-m-map-pin')
                                            ->suffixIconColor('danger')
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => trim(htmlspecialchars($state))),
                                    ])->columns(2),
                                Grid::make('Victory')
                                    ->schema(components: [
                                        Toggle::make('is_winner')
                                            ->label('Gagnant')
                                            ->onIcon('heroicon-o-check')
                                            ->onColor('success')
                                            ->offIcon('heroicon-o-x-mark')
                                            ->offColor('danger')
                                            ->default(false),
                                    ])->columns(2),
                            ]),
                        Tab::make('Description de l\'association')
                            ->icon('heroicon-m-newspaper')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Textarea::make('description')
                                    ->label('Présentation')
                                    ->placeholder('Ecrivez la description de l\'association ici')
                                    ->helperText('Maximum de 5000 caractères')
                                    ->required()
                                    ->string()
                                    ->maxlength(5000)
                                    ->rows(10)
                                    ->cols(20)
                                    ->autosize()
                                    ->dehydrateStateUsing(/**
                                     * @param string $state
                                     * @return string
                                     */ callback: fn (string $state) => ucfirst(htmlspecialchars($state, ENT_COMPAT))),
                            ]),
                        Tab::make('Description du projet')
                            ->icon('heroicon-m-clipboard-document-check')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Textarea::make('project')
                                    ->label('Projet')
                                    ->placeholder('Ecrivez la description du projet de l\'association ici')
                                    ->helperText('Maximum de 5000 caractères')
                                    ->required()
                                    ->string()
                                    ->maxlength(5000)
                                    ->rows(10)
                                    ->cols(20)
                                    ->autosize()
                                    ->dehydrateStateUsing(/**
                                     * @param string $state
                                     * @return string
                                     */ callback: fn (string $state) => ucfirst(htmlspecialchars($state, ENT_COMPAT))),
                            ]),
                        Tab::make('Logo')
                            ->icon('heroicon-m-photo')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                SpatieMediaLibraryFileUpload::make('thumbnail')
                                    ->label('Logo')
                                    ->helperText('Formats autorisés: JPEG et PNG')
                                    ->required()
                                    ->maxSize(1024)
                                    ->acceptedFileTypes(Collection::make(['image/jpeg', 'image/png']))
                                    ->rules('mimes:jpeg,png')
                                    ->collection('associations'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    /**
     * Define the table structure for listing associations
     *
     * @param Table $table
     * @return Table
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
        return $table
            ->heading('Gestion des associations')
            ->description('Listing, ajout, modification et suppression d\'associations.')
            ->deferLoading()
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Nom')
                    ->icon('heroicon-m-tag')
                    ->iconColor('danger')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
                TextColumn::make('slug')
                    ->icon('heroicon-m-bookmark')
                    ->iconColor('danger')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('siret')
                    ->label('SIRET')
                    ->icon('heroicon-m-information-circle')
                    ->iconColor('danger')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('city')
                    ->label('Code postal')
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('danger')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
                IconColumn::make('is_winner')
                    ->label('Gagnant')
                    ->alignCenter()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('points')
                    ->label('Points')
                    ->icon('heroicon-m-calculator')
                    ->iconColor('danger')
                    ->numeric()
                    ->sortable()
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
                TernaryFilter::make('is_winner')
                    ->label('Gagnant')
                    ->placeholder('Tout')
                    ->trueLabel('Gagnant')
                    ->falseLabel('Perdant')
                    ->queries(
                    /**
                     * @param Builder $query
                     * @return Builder
                     */ true: fn (Builder $query) => $query->where('is_winner', true),
                        false: fn (Builder $query) => $query->where('is_winner', false),
                    ),
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
                    ->successNotificationTitle('Association modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer cette association ?')
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Association supprimée')
                    ->after(/**
                     * @return void
                     */ function () {
                        Statistic::updateAssociationOnDelete();
                    }),
            ])
            ->searchPlaceholder('Rechercher une association')
            ->persistSearchInSession()
            ->persistFiltersInSession()
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
            'index' => ManageAssociations::route('/'),
        ];
    }
}
