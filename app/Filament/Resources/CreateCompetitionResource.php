<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreateCompetitionResource\Pages\ManageCreateCompetitions;
use App\Models\CreateCompetition;
use Exception;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CreateCompetitionResource extends Resource
{
    protected static ?string $model = CreateCompetition::class;

    protected static ?string $navigationGroup = 'Gestion des compétitions';

    protected static ?string $navigationLabel = 'Planifications';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $activeNavigationIcon = 'heroicon-s-arrow-path-rounded-square';

    public static function form(Form $form): Form
    {
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
                                            ->afterStateUpdated(callback: fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                            ->dehydrateStateUsing(callback: fn (string $state) => ucfirst(htmlspecialchars($state))),
                                        TextInput::make('slug')
                                            ->placeholder('Slug')
                                            ->required()
                                            ->string()
                                            ->alphaDash()
                                            ->maxLength(50)
                                            ->suffixIcon('heroicon-m-bookmark')
                                            ->suffixIconColor('danger')
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                                    ])->columns(2),
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
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
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
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
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
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
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
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                                    ])->columns(2),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
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
                SelectFilter::make('competition.status')
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
                    ->modalWidth(MaxWidth::ThreeExtraLarge)
                    ->successNotificationTitle('Planification modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sur de vouloir supprimer cette planification ?')
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Planification supprimée'),
            ])
            ->searchPlaceholder('Rechercher une planification')
            ->persistSearchInSession()
            ->paginated(condition: [10, 25, 50, 100, 'all']);
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageCreateCompetitions::route('/'),
        ];
    }

    public static function getPluralLabel(): string
    {
        return __(key: 'Planifications');
    }

    public static function getLabel(): string
    {
        return __(key: 'une planification');
    }
}
