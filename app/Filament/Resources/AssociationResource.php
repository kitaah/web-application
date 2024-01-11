<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssociationResource\Pages\ManageAssociations;
use App\Models\Association;
use Exception;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JsonException;

class AssociationResource extends Resource
{
    protected static ?string $model = Association::class;

    protected static ?string $navigationGroup = 'Gestion des compétitions';

    protected static ?string $navigationLabel = 'Associations';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $activeNavigationIcon = 'heroicon-s-building-storefront';

    /**
     * @throws JsonException
     */
    public static function form(Form $form): Form
    {
        $association = new Association();
        $cities = $association->fetchCitiesFromAPI();
        $cityOptions = $cities->pluck('label', 'id')->toArray();

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
                                            ->afterStateUpdated(callback: fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
                                        TextInput::make('slug')
                                            ->placeholder('Slug')
                                            ->required()
                                            ->string()
                                            ->maxLength(50)
                                            ->suffixIcon('heroicon-m-bookmark')
                                            ->suffixIconColor('danger')
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
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
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                                        Select::make('city')
                                            ->label('Ville')
                                            ->placeholder('Sélectionnez une ville')
                                            ->required()
                                            ->preload()
                                            ->options($cityOptions)
                                            ->suffixIcon('heroicon-m-map-pin')
                                            ->suffixIconColor('danger')
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
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
                                    ->dehydrateStateUsing(callback: fn (string $state) => ucfirst(htmlspecialchars($state, ENT_COMPAT))),
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
                                    ->dehydrateStateUsing(callback: fn (string $state) => ucfirst(htmlspecialchars($state, ENT_COMPAT))),
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
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
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
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
                TextColumn::make('slug')
                    ->icon('heroicon-m-bookmark')
                    ->iconColor('danger')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('siret')
                    ->label('SIRET')
                    ->icon('heroicon-m-information-circle')
                    ->iconColor('danger')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('city')
                    ->label('Code postal')
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('danger')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
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
                callback: fn (Action $action) => $action
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
                        true: fn (Builder $query) => $query->where('is_winner', true),
                        false: fn (Builder $query) => $query->where('is_winner', false),
                    ),
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
                    ->successNotificationTitle('Association modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sur de vouloir supprimer cette association ?')
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Association supprimée'),
            ])
            ->searchPlaceholder('Rechercher une association')
            ->persistSearchInSession()
            ->persistFiltersInSession()
            ->paginated(condition: [10, 25, 50, 100, 'all']);
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageAssociations::route('/'),
        ];
    }

    public static function getPluralLabel(): string
    {
        return __(key: 'Associations');
    }

    public static function getLabel(): string
    {
        return __(key: 'une association');
    }
}
