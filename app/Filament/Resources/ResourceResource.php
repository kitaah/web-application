<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResourceResource\Pages\ManageResources;
use Exception;
use App\Models\{Resource as ResourceModel, User};
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
    Support\Enums\MaxWidth,
    Tables\Actions\Action,
    Tables\Actions\DeleteAction,
    Tables\Actions\EditAction,
    Tables\Columns\IconColumn,
    Tables\Columns\TextColumn,
    Tables\Filters\SelectFilter,
    Tables\Filters\TernaryFilter,
    Tables\Table};
use Illuminate\{Database\Eloquent\Builder, Support\Collection, Support\Facades\Auth, Support\Str};

class ResourceResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = ResourceModel::class;

    /**
     * Navigation group for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Gestion des ressources';

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Ressources';

    /**
     * Get the singular label for the resource.
     *
     * @var string|null
     */
    protected static ?string $label = 'une ressource';

    /**
     * The slug used for this resource.
     *
     * @var string|null
     */
    protected static ?string $slug = 'ressources';

    /**
     * Navigation label for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationLabel = 'Ressources';

    /**
     * Navigation sort order for the resource.
     *
     * @var int|null
     */
    protected static ?int $navigationSort = 2;

    /**
     * Navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-rectangle-stack';

    /**
     * Define the form structure for creating and updating resources.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        $userId = Auth::id();
        $user = User::find($userId);

        /** @var $form */
        return $form
            ->schema(components: [
                Hidden::make('user_id')
                    ->required()
                    ->regex('/^[0-9]+$/i')
                    ->default($userId),
                Tabs::make('Tabs')
                    ->tabs(tabs: [
                        Tab::make('Informations générales')
                            ->icon('heroicon-m-tag')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Grid::make('Name and category')
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
                                             */ callback: fn (string $state) => ucfirst(htmlspecialchars($state, ENT_COMPAT))),
                                        Select::make('category_id')
                                            ->label('Catégorie')
                                            ->placeholder('Sélectionnez une catégorie')
                                            ->required()
                                            ->regex('/^[0-9]+$/i')
                                            ->relationship('category', 'name')
                                            ->suffixIcon('heroicon-m-bars-3')
                                            ->suffixIconColor('danger')
                                            ->preload()
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => htmlspecialchars($state)),
                                    ])->columns(),
                                Grid::make('Slug and url')
                                    ->schema(components: [
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
                                        TextInput::make('url')
                                            ->placeholder('Http(s)://')
                                            ->string()
                                            ->activeUrl()
                                            ->maxLength(255)
                                            ->suffixIcon('heroicon-m-globe-alt')
                                            ->suffixIconColor('danger')
                                            ->dehydrateStateUsing(/**
                                             * @param $state
                                             * @return mixed|string
                                             */ callback: fn ($state) => is_string($state) ? htmlspecialchars($state) : $state),
                                    ])->columns(),
                                Grid::make('Validation and status')
                                    ->schema(components: [
                                        Toggle::make('is_validated')
                                            ->label('Validation')
                                            ->onIcon('heroicon-o-check')
                                            ->onColor('success')
                                            ->offIcon('heroicon-o-x-mark')
                                            ->offColor('danger')
                                            ->default(false),
                                        Select::make('status')
                                            ->label('Statut')
                                            ->placeholder('Sélectionnez un statut')
                                            ->required()
                                            ->string()
                                            ->suffixIcon('heroicon-m-information-circle')
                                            ->suffixIconColor('danger')
                                            ->options([
                                                'En attente' => 'En attente',
                                                'Publiée' => 'Publiée',
                                                'Suspendue' => 'Suspendue',
                                            ])
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => htmlspecialchars($state)),
                                    ])->columns(),
                            ]),
                        Tab::make('Description')
                            ->icon('heroicon-m-newspaper')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Textarea::make('description')
                                    ->placeholder('Ecrivez votre description ici')
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
                        Tab::make('Image')
                            ->icon('heroicon-m-photo')
                            ->iconPosition(IconPosition::After)
                            ->columnSpanFull()
                            ->schema(components: [
                                SpatieMediaLibraryFileUpload::make('thumbnail')
                                    ->label('Image')
                                    ->helperText('Formats autorisés: JPEG et PNG')
                                    ->required()
                                    ->maxSize(1024)
                                    ->acceptedFileTypes(Collection::make(['image/jpeg', 'image/png']))
                                    ->rules('mimes:jpeg,png')
                                    ->collection('image'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    /**
     * Define the table structure for listing roles.
     *
     * @param Table $table
     * @return Table
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
        return $table
            ->heading('Gestion des ressources')
            ->description('Listing, ajout, modification et suppression des ressources.')
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
                IconColumn::make('is_validated')
                    ->label('Validation')
                    ->alignCenter()
                    ->boolean(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->alignCenter()
                    ->colors([
                        'warning' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'En attente',
                        'success' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'Publiée',
                        'danger' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'Suspendue',
                    ])
                    ->icons([
                        'heroicon-s-arrow-path' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'En attente',
                        'heroicon-s-book-open' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'Publiée',
                        'heroicon-s-x-mark' => /**
                         * @param $state
                         * @return bool
                         */ static fn ($state): bool => $state === 'Suspendue',
                    ])
                    ->iconPosition('before')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('user.name')
                    ->label('Créateur')
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('danger'),
                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->icon('heroicon-m-bars-3')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->icon('heroicon-m-bookmark')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state))
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
                SelectFilter::make('category')
                    ->label('Catégorie')
                    ->relationship('category', 'name'),
                TernaryFilter::make('is_validated')
                    ->label(__('Validation'))
                    ->placeholder('Tout')
                    ->trueLabel('Validée')
                    ->falseLabel('Non validée')
                    ->queries(
                    /**
                     * @param Builder $query
                     * @return Builder
                     */ true: fn (Builder $query) => $query->where('is_validated', true),
                        false: fn (Builder $query) => $query->where('is_validated', false),
                    ),
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'En attente' => 'En attente',
                        'Publiée' => 'Publiée',
                        'Suspendue' => 'Suspendue',
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
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->successNotificationTitle('Ressource modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer cette ressource ?')
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Ressource supprimée'),
            ])
            ->searchPlaceholder('Rechercher une ressource')
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
            'index' => ManageResources::route('/'),
        ];
    }
}
