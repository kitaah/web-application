<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages\ManagePermissions;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationGroup = 'Gestion des comptes';

    protected static ?string $navigationLabel = 'Permissions';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $activeNavigationIcon = 'heroicon-s-key';

    public static function form(Form $form): Form
    {
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
                    ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Gestion des permissions')
            ->description('Listing, ajout, modification et suppression de permissions.')
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Permissions')
                    ->searchable()
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
            ->actions([
                EditAction::make()
                    ->color('warning')
                    ->button()
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('danger'))
                    ->modalWidth(MaxWidth::Large)
                    ->modalAlignment(Alignment::Center)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->successNotificationTitle('Permission modifiée'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sur de vouloir supprimer cette permission ?')
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Permission supprimée'),
            ])
            ->searchPlaceholder('Rechercher une permission')
            ->persistSearchInSession()
            ->persistFiltersInSession()
            ->paginated(condition: [10, 20, 50, 100, 'all']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePermissions::route('/'),
        ];
    }

    public static function getPluralLabel(): string
    {
        return __(key: 'Permissions');
    }

    public static function getLabel(): string
    {
        return __(key: 'une permission');
    }
}
