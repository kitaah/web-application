<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages\ManagePermissions;
use Filament\{Actions\StaticAction,
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
use Spatie\Permission\Models\Permission;

class PermissionResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = Permission::class;

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Permissions';

    /**
     * Get the singular label for the resource.
     *
     * @var string|null
     */
    protected static ?string $label = 'une permission';

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
    protected static ?string $navigationLabel = 'Permissions';

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
    protected static ?string $navigationIcon = 'heroicon-o-key';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-key';

    /**
     * Define the form structure for creating and updating permissions.
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
                    ->label('Permission')
                    ->required()
                    ->placeholder('Permission')
                    ->string()
                    ->autofocus()
                    ->maxLength(50)
                    ->suffixIcon('heroicon-m-key')
                    ->suffixIconColor('danger')
                    ->unique(ignoreRecord: true)
                    ->dehydrateStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
            ]);
    }

    /**
     * Define the table structure for listing permissions.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
        return $table
            ->heading('Gestion des permissions')
            ->description('Listing, ajout, modification et suppression de permissions.')
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Permissions')
                    ->searchable()
                    ->icon('heroicon-m-key')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
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
                    ->modalWidth(MaxWidth::Large)
                    ->modalAlignment(Alignment::Center)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->successNotificationTitle('Permission modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer cette permission ?')
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Permission supprimée'),
            ])
            ->searchPlaceholder('Rechercher une permission')
            ->persistSearchInSession()
            ->persistFiltersInSession()
            ->paginated(condition: [10, 20, 50, 100, 'all']);
    }

    /**
     * Get the pages associated with the resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ManagePermissions::route('/'),
        ];
    }
}
