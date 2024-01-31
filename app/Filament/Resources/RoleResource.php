<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages\ManageRoles;
use Filament\{Actions\StaticAction,
    Forms\Components\Select,
    Forms\Components\TextInput,
    Forms\Form,
    Resources\Resource,
    Support\Enums\Alignment,
    Support\Enums\MaxWidth,
    Tables\Actions\Action,
    Tables\Actions\DeleteAction,
    Tables\Actions\EditAction,
    Tables\Columns\TextColumn,
    Tables\Table};
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = Role::class;

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Rôles';

    /**
     * Get the singular label for the resource.
     *
     * @var string|null
     */
    protected static ?string $label = 'un rôle';

    /**
     * Navigation group for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Gestion des comptes';

    /**
     * Navigation label for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationLabel = 'Rôles';

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
    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-finger-print';

    /**
     * Define the form structure for creating and updating roles.
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
                    ->label('Rôle')
                    ->required()
                    ->autofocus()
                    ->string()
                    ->maxLength(60)
                    ->suffixIcon('heroicon-m-finger-print')
                    ->suffixIconColor('danger')
                    ->unique(ignoreRecord: true)
                    ->dehydrateStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => ucfirst(trim(htmlspecialchars($state)))),
                Select::make('permissions')
                    ->required()
                    ->placeholder('Sélectionnez une/des permission(s)')
                    ->multiple()
                    ->relationship('permissions', 'name')
                    ->preload()
                    ->searchPrompt('Rechercher une permission')
                    ->loadingMessage('Chargement des permissions...')
                    ->noSearchResultsMessage('Aucune permission trouvée')
                    ->optionsLimit(20)
                    ->suffixIcon('heroicon-m-key')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => trim(htmlspecialchars($state))),
            ]);
    }

    /**
     * Define the table structure for listing roles.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
        return $table
            ->heading('Gestion des rôles')
            ->description('Listing, ajout, modification et suppression de rôles.')
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Rôles')
                    ->icon('heroicon-m-finger-print')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars(ucfirst(trim(($state))))),
                TextColumn::make('permissions.name')
                    ->label('Permissions')
                    ->icon('heroicon-m-key')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars(ucfirst(trim(($state))))),
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
            ->actions(actions: [
                EditAction::make()
                    ->color('warning')
                    ->button()
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('danger'))
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->modalAlignment(Alignment::Center)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->successNotificationTitle('Rôle modifié'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer ce rôle ?')
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Rôle supprimé'),
            ])
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
            'index' => ManageRoles::route('/'),
        ];
    }
}
