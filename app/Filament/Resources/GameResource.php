<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages\ManageGames;
use App\Models\Game;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationGroup = 'Gestion des jeux';

    protected static ?string $navigationLabel = 'Quizz vrai/faux';

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $activeNavigationIcon = 'heroicon-s-question-mark-circle';

    public static function form(Form $form): Form
    {
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
                    ->dehydrateStateUsing(callback: fn (string $state) => ucfirst($state))
                    ->live(debounce: 250)
                    ->debounce(250)
                    ->afterStateUpdated(callback: fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
                TextInput::make('slug')
                    ->placeholder('Slug')
                    ->required()
                    ->string()
                    ->alphaDash()
                    ->required()
                    ->maxLength(50)
                    ->suffixIcon('heroicon-m-bookmark')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
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
                    ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Gestion des quizz vrai/faux')
            ->description('Listing, ajout, modification et suppression de quizz vrai/faux.')
            ->deferLoading()
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('danger')
                    ->searchable()
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
                TextColumn::make('question')
                    ->label('Question')
                    ->icon('heroicon-m-question-mark-circle')
                    ->iconColor('danger')
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state, ENT_COMPAT)),
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
            ->actions([
                EditAction::make()
                    ->color('warning')
                    ->button()
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('danger'))
                    ->modalAlignment(Alignment::Center)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->successNotificationTitle('Jeu modifié'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sur de vouloir supprimer ce jeu ?')
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Jeu supprimé'),
            ])
            ->searchPlaceholder('Rechercher un quizz')
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
            'index' => ManageGames::route('/'),
        ];
    }

    public static function getPluralLabel(): string
    {
        return __(key: 'Jeux');
    }

    public static function getLabel(): string
    {
        return __(key: 'un jeu');
    }
}
