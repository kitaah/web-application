<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages\ManageCategories;
use App\Models\Category;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\TextInput;
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

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationGroup = 'Gestion des ressources';

    protected static ?string $navigationLabel = 'Catégories';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $activeNavigationIcon = 'heroicon-s-bars-3';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                components: [
                    TextInput::make('name')
                        ->label('Nom')
                        ->placeholder('Nom')
                        ->required()
                        ->autofocus()
                        ->string()
                        ->alphaDash()
                        ->maxLength(50)
                        ->suffixIcon('heroicon-m-bars-3')
                        ->suffixIconColor('danger')
                        ->unique(ignoreRecord: true)
                        ->live(debounce: 250)
                        ->debounce(250)
                        ->dehydrateStateUsing(callback: fn (string $state) => ucfirst(htmlspecialchars($state)))
                        ->afterStateUpdated(callback: fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->required()
                        ->placeholder('Slug')
                        ->string()
                        ->alphaDash()
                        ->maxLength(50)
                        ->suffixIcon('heroicon-m-bookmark')
                        ->suffixIconColor('danger')
                        ->unique(ignoreRecord: true)
                        ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                ]
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Gestion des catégories')
            ->description('Listing, ajout, modification et suppression de catégories.')
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Nom')
                    ->icon('heroicon-m-bars-3')
                    ->iconColor('danger')
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('slug')
                    ->icon('heroicon-m-bookmark')
                    ->iconColor('danger')
                    ->formatStateUsing(fn (string $state) => htmlspecialchars($state))
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
            ->actions(
                [
                    EditAction::make()
                        ->color('warning')
                        ->button()
                        ->modalCancelAction(fn (StaticAction $action) => $action->color('danger'))
                        ->modalAlignment(Alignment::Center)
                        ->modalFooterActionsAlignment(Alignment::Center)
                        ->modalWidth(MaxWidth::TwoExtraLarge)
                        ->successNotificationTitle('Catégorie modifiée'),
                    DeleteAction::make()
                        ->button()
                        ->modalHeading('Suppression')
                        ->modalDescription('Êtes-vous sur de vouloir supprimer cette catégorie ?')
                        ->modalCancelAction(fn (StaticAction $action) => $action->color('info'))
                        ->modalSubmitActionLabel('Supprimer')
                        ->successNotificationTitle('Catégorie supprimée'),
                ]
            )
            ->paginated([10, 25, 50, 100, 'all']);
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageCategories::route('/'),
        ];
    }

    public static function getPluralLabel(): string
    {
        return __(key: 'Catégories');
    }

    public static function getLabel(): string
    {
        return __(key: 'une catégorie');
    }
}
