<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages\ManageRoles;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationGroup = 'Gestion des comptes';

    protected static ?string $navigationLabel = 'Rôles';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    protected static ?string $activeNavigationIcon = 'heroicon-s-finger-print';

    public static function form(Form $form): Form
    {
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
                    ->dehydrateStateUsing(callback: fn (string $state) => ucfirst(htmlspecialchars($state))),
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
                    ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Gestion des rôles')
            ->description('Listing, ajout, modification et suppression de rôles.')
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Rôles')
                    ->icon('heroicon-m-finger-print')
                    ->iconColor('danger'),
                TextColumn::make('permissions.name')
                    ->label('Permissions')
                    ->icon('heroicon-m-key')
                    ->iconColor('danger')
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
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
            ->actions(actions: [
                EditAction::make()
                    ->color('warning')
                    ->button()
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('danger'))
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->modalAlignment(Alignment::Center)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->successNotificationTitle('Rôle modifié'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sur de vouloir supprimer ce rôle ?')
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Rôle supprimé'),
            ])
            ->persistFiltersInSession()
            ->paginated(condition: [10, 25, 50, 100, 'all']);
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageRoles::route('/'),
        ];
    }

    public static function getPluralLabel(): string
    {
        return __(key: 'Rôles');
    }

    public static function getLabel(): string
    {
        return __(key: 'un rôle');
    }
}
