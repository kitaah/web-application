<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages\ManageGames;
use App\Models\Game;
use Filament\{Actions\StaticAction,
    Forms\Components\TextInput,
    Forms\Components\Toggle,
    Forms\Form,
    Forms\Set,
    Resources\Resource,
    Support\Enums\Alignment,
    Support\Enums\MaxWidth,
    Tables\Actions\Action,
    Tables\Actions\DeleteAction,
    Tables\Actions\EditAction,
    Tables\Columns\TextColumn,
    Tables\Table};
use App\Models\Statistic;
use Illuminate\Support\Str;

class GameResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = Game::class;

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Jeux';

    /**
     * Get the singular label for the resource.
     *
     * @var string|null
     */
    protected static ?string $label = 'un jeu';

    /**
     * The slug used for this resource.
     *
     * @var string|null
     */
    protected static ?string $slug = 'jeux';

    /**
     * Navigation group for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Gestion des jeux';

    /**
     * Navigation label for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationLabel = 'Quiz vrai/faux';

    /**
     * Navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-question-mark-circle';

    /**
     * Define the form structure for creating and updating games.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        /** @var $form */
        return $form
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
                     */ callback: fn (string $state) => ucfirst(trim(htmlspecialchars($state, ENT_COMPAT)))),
                TextInput::make('slug')
                    ->placeholder('Slug')
                    ->required()
                    ->string()
                    ->alphaDash()
                    ->required()
                    ->maxLength(50)
                    ->suffixIcon('heroicon-m-bookmark')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => trim(htmlspecialchars($state))),
                Toggle::make('is_right')
                    ->label('Réponse')
                    ->onIcon('heroicon-o-check')
                    ->onColor('success')
                    ->offIcon('heroicon-o-x-mark')
                    ->offColor('danger')
                    ->default(false),
                TextInput::make('question')
                    ->placeholder('Question')
                    ->required()
                    ->string()
                    ->maxLength(120)
                    ->suffixIcon('heroicon-m-question-mark-circle')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => ucfirst(trim(htmlspecialchars($state, ENT_COMPAT)))),
            ]);
    }

    /**
     * Define the table structure for listing games.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
        return $table
            ->heading('Gestion des quiz vrai/faux')
            ->description('Listing, ajout, modification et suppression de quiz vrai/faux.')
            ->deferLoading()
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('danger')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => ucfirst(trim(htmlspecialchars($state, ENT_COMPAT)))),
                TextColumn::make('question')
                    ->label('Question')
                    ->icon('heroicon-m-question-mark-circle')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => ucfirst(trim(htmlspecialchars($state, ENT_COMPAT)))),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->icon('heroicon-m-bookmark')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => trim(htmlspecialchars($state, ENT_COMPAT)))
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
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->successNotificationTitle('Quiz modifié'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer ce quiz ?')
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Quiz supprimé')
                    ->after(/**
                     * @return void
                     */ function () {
                        Statistic::updateGameOnDelete();
                    }),
            ])
            ->searchPlaceholder('Rechercher un quiz')
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
            'index' => ManageGames::route('/'),
        ];
    }
}
