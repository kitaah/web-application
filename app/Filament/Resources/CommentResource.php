<?php

namespace App\Filament\Resources;

use App\Models\Statistic;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Filament\{Resources\CommentResource\Pages,
    Resources\CommentResource\Pages\ManageComments,
    Resources\CommentResource\RelationManagers};
use App\Models\Comment;
use Filament\{Actions\StaticAction,
    Forms,
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
    Resources\Pages\PageRegistration,
    Resources\Resource,
    Support\Enums\Alignment,
    Support\Enums\IconPosition,
    Support\Enums\MaxWidth,
    Tables,
    Tables\Actions\Action,
    Tables\Actions\DeleteAction,
    Tables\Actions\EditAction,
    Tables\Columns\IconColumn,
    Tables\Columns\TextColumn,
    Tables\Filters\TernaryFilter,
    Tables\Table};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = Comment::class;

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Commentaires';

    /**
     * Get the singular label for the resource.
     *
     * @var string|null
     */
    protected static ?string $label = 'la gestion du commentaire';

    /**
     * The slug used for this resource.
     *
     * @var string|null
     */
    protected static ?string $slug = 'commentaires';

    /**
     * Navigation group for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Gestion des commentaires';

    /**
     * Navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-chat-bubble-left';

    /**
     * Define the form structure for managing the comments.
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
                        Tab::make('Informations générales')
                            ->icon('heroicon-m-tag')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Grid::make('Slug and url')
                                    ->schema(components: [
                                        Select::make('resource_id')
                                            ->label('Ressource')
                                            ->disabled()
                                            ->relationship('resource', 'name')
                                            ->required()
                                            ->suffixIcon('heroicon-m-rectangle-stack')
                                            ->suffixIconColor('danger')
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => trim(htmlspecialchars($state, ENT_COMPAT))),
                                        Select::make('user_id')
                                            ->label('Utilisateur')
                                            ->disabled()
                                            ->relationship('user', 'name')
                                            ->required()
                                            ->suffixIcon('heroicon-m-user-circle')
                                            ->suffixIconColor('danger')
                                            ->dehydrateStateUsing(/**
                                             * @param string $state
                                             * @return string
                                             */ callback: fn (string $state) => trim(htmlspecialchars($state, ENT_COMPAT))),
                                    ])->columns(),
                                Grid::make('Validation and status')
                                    ->schema(components: [
                                        Toggle::make('is_reported')
                                            ->label('Signalé')
                                            ->onIcon('heroicon-o-check')
                                            ->onColor('success')
                                            ->offIcon('heroicon-o-x-mark')
                                            ->offColor('danger')
                                            ->default(false),
                                        Toggle::make('is_user_banned')
                                            ->label('Banni')
                                            ->onIcon('heroicon-o-check')
                                            ->onColor('success')
                                            ->offIcon('heroicon-o-x-mark')
                                            ->offColor('danger')
                                            ->default(false),
                                    ])->columns(),
                            ]),
                        Tab::make('Commentaire utilisateur')
                            ->icon('heroicon-m-chat-bubble-left')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Textarea::make('content')
                                    ->label('Commentaire')
                                    ->disabled()
                                    ->string()
                                    ->maxlength(500)
                                    ->rows(10)
                                    ->cols(20)
                                    ->autosize()
                                    ->dehydrateStateUsing(/**
                                     * @param string $state
                                     * @return string
                                     */ callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
                                Toggle::make('is_published')
                                    ->label('Publié')
                                    ->onIcon('heroicon-o-check')
                                    ->onColor('success')
                                    ->offIcon('heroicon-o-x-mark')
                                    ->offColor('danger')
                                    ->default(false),
                            ]),
                        Tab::make('Raison de la modération')
                            ->icon('heroicon-m-chat-bubble-left')
                            ->iconPosition(IconPosition::After)
                            ->schema(components: [
                                Textarea::make('moderation_comment')
                                    ->label('Commentaire')
                                    ->helperText('Maximum de 500 caractères')
                                    ->required()
                                    ->string()
                                    ->maxlength(500)
                                    ->rows(10)
                                    ->cols(20)
                                    ->autosize()
                                    ->dehydrateStateUsing(/**
                                     * @param string $state
                                     * @return string
                                     */ callback: fn (string $state) => ucfirst(htmlspecialchars($state, ENT_COMPAT))),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    /**
     * Define the table structure for listing comments
     *
     * @param Table $table
     * @return Table
     * @throws Exception|Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->heading('Gestion des commentaires')
            ->description('Getion des commentaires postés par les citoyens.')
            ->deferLoading()
            ->columns([
                TextColumn::make('resource.name')
                    ->label('Ressource')
                    ->numeric()
                    ->icon('heroicon-m-rectangle-stack')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => trim(htmlspecialchars($state))),
                TextColumn::make('user.name')
                    ->label('Utilisateur')
                    ->numeric()
                    ->searchable()
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => trim(htmlspecialchars($state))),
                IconColumn::make('is_published')
                    ->label('Publié')
                    ->boolean()
                    ->alignCenter(),
                IconColumn::make('is_reported')
                    ->label('Signalé')
                    ->boolean()
                    ->alignCenter(),
                IconColumn::make('is_user_banned')
                    ->label('Bannissement')
                    ->boolean()
                    ->alignCenter(),
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
                TernaryFilter::make('is_published')
                    ->label('Publication')
                    ->placeholder('Tout')
                    ->trueLabel('Publié')
                    ->falseLabel('Non publié')
                    ->queries(
                    /**
                     * @param Builder $query
                     * @return Builder
                     */ true: fn (Builder $query) => $query->where('is_published', true),
                        false: fn (Builder $query) => $query->where('is_published', false),
                    ),
                TernaryFilter::make('is_reported')
                    ->label('Signalé')
                    ->placeholder('Tout')
                    ->trueLabel('Signalé')
                    ->falseLabel('Non signalé')
                    ->queries(
                    /**
                     * @param Builder $query
                     * @return Builder
                     */ true: fn (Builder $query) => $query->where('is_reported', true),
                        false: fn (Builder $query) => $query->where('is_reported', false),
                    ),
                TernaryFilter::make('is_user_banned')
                    ->label('Utilisateur banni')
                    ->placeholder('Tout')
                    ->trueLabel('Banni')
                    ->falseLabel('Non banni')
                    ->queries(
                    /**
                     * @param Builder $query
                     * @return Builder
                     */ true: fn (Builder $query) => $query->where('is_user_banned', true),
                        false: fn (Builder $query) => $query->where('is_user_banned', false),
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
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->successNotificationTitle('Action en lien avec le commentaire modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer ce commentaire ?')
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Commentaire supprimé'),
            ])
            ->searchPlaceholder('Rechercher un utilisateur')
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
            'index' => ManageComments::route('/'),
        ];
    }
}
