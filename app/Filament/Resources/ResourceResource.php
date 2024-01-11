<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResourceResource\Pages\ManageResources;
use App\Models\Resource as ResourceModel;
use App\Models\User;
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
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResourceResource extends Resource
{
    protected static ?string $model = ResourceModel::class;

    protected static ?string $navigationGroup = 'Gestion des ressources';

    protected static ?string $navigationLabel = 'Ressources';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $activeNavigationIcon = 'heroicon-s-rectangle-stack';

    /**
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        $userId = Auth::id();
        $user = User::find($userId);

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
                                            ->afterStateUpdated(callback: fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                            ->dehydrateStateUsing(callback: fn (string $state) => ucfirst(htmlspecialchars($state, ENT_COMPAT))),
                                        Select::make('category_id')
                                            ->label('Catégorie')
                                            ->placeholder('Sélectionnez une catégorie')
                                            ->required()
                                            ->regex('/^[0-9]+$/i')
                                            ->relationship('category', 'name')
                                            ->suffixIcon('heroicon-m-bars-3')
                                            ->suffixIconColor('danger')
                                            ->preload()
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                                    ])->columns(2),
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
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                                        TextInput::make('url')
                                            ->placeholder('Http(s)://')
                                            ->string()
                                            ->activeUrl()
                                            ->maxLength(255)
                                            ->suffixIcon('heroicon-m-globe-alt')
                                            ->suffixIconColor('danger')
                                            ->dehydrateStateUsing(callback: fn ($state) => is_string($state) ? htmlspecialchars($state) : $state),
                                    ])->columns(2),
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
                                            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                                    ])->columns(2),
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
                                    ->dehydrateStateUsing(callback: fn (string $state) => ucfirst(htmlspecialchars($state, ENT_COMPAT))),
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
                                    ->collection('resources', 'resources_img'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    /**
     * @param Table $table
     * @return Table
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
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
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
                IconColumn::make('is_validated')
                    ->label('Validation')
                    ->alignCenter()
                    ->boolean(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->alignCenter()
                    ->colors([
                        'warning' => static fn ($state): bool => $state === 'En attente',
                        'success' => static fn ($state): bool => $state === 'Publiée',
                        'danger' => static fn ($state): bool => $state === 'Suspendue',
                    ])
                    ->icons([
                        'heroicon-s-arrow-path' => static fn ($state): bool => $state === 'En attente',
                        'heroicon-s-book-open' => static fn ($state): bool => $state === 'Publiée',
                        'heroicon-s-x-mark' => static fn ($state): bool => $state === 'Suspendue',
                    ])
                    ->iconPosition('before')
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('user.name')
                    ->label('Créateur')
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('danger'),
                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->icon('heroicon-m-bars-3')
                    ->iconColor('danger')
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->icon('heroicon-m-bookmark')
                    ->iconColor('danger')
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state))
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
                SelectFilter::make('category')
                    ->label('Catégorie')
                    ->relationship('category', 'name'),
                TernaryFilter::make('is_validated')
                    ->label(__('Validation'))
                    ->placeholder('Tout')
                    ->trueLabel('Validée')
                    ->falseLabel('Non validée')
                    ->queries(
                        true: fn (Builder $query) => $query->where('is_validated', true),
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
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->successNotificationTitle('Ressource modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sur de vouloir supprimer cette ressource ?')
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Ressource supprimée'),
            ])
            ->searchPlaceholder('Rechercher une ressource')
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
            'index' => ManageResources::route('/'),
        ];
    }

    /**
     * @return string
     */
    public static function getPluralLabel(): string
    {
        return __(key: 'Ressources');
    }

    /**
     * @return string
     */
    public static function getLabel(): string
    {
        return __(key: 'une ressource');
    }
}
