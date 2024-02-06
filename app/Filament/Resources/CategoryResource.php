<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages\ManageCategories;
use App\Models\Category;
use Filament\{Actions\StaticAction,
    Forms\Components\TextInput,
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
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = Category::class;

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Catégories';

    /**
     * Get the singular label for the resource.
     *
     * @var string|null
     */
    protected static ?string $label = 'une catégorie';

    /**
     * Navigation group for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Gestion des catégories';

    /**
     * Navigation label for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationLabel = 'Catégories';

    /**
     * Navigation sort order for the resource.
     *
     * @var int|null
     */
    protected static ?int $navigationSort = 1;

    /**
     * Navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-bars-3';

    /**
     * Define the form structure for creating and updating categories.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        /** @var $form */
        return $form
            ->schema(
                components: [
                    TextInput::make('name')
                        ->label('Nom')
                        ->placeholder('Nom')
                        ->required()
                        ->autofocus()
                        ->string()
                        ->maxLength(50)
                        ->suffixIcon('heroicon-m-bars-3')
                        ->suffixIconColor('danger')
                        ->unique(ignoreRecord: true)
                        ->live(debounce: 250)
                        ->debounce(250)
                        ->dehydrateStateUsing(callback: fn (string $state) => ucfirst(trim(htmlspecialchars($state, ENT_COMPAT))))
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
                        ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars(trim($state))),
                ]
            );
    }

    /**
     * Define the table structure for listing categories
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
        return $table
            ->heading('Gestion des catégories')
            ->description('Listing, ajout, modification et suppression de catégories associées aux ressources et associations.')
            ->deferLoading()
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Nom')
                    ->icon('heroicon-m-bars-3')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => ucfirst(trim(htmlspecialchars($state, ENT_COMPAT)))),
                TextColumn::make('slug')
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
                callback: fn (Action $action) => $action
                    ->color('info')
                    ->label('Ajouter des colonnes'),
            )
            ->actions(
                [
                    EditAction::make()
                        ->color('warning')
                        ->button()
                        ->modalCancelAction(/**
                         * @param StaticAction $action
                         * @return StaticAction
                         */ fn (StaticAction $action) => $action->color('danger'))
                        ->modalAlignment(Alignment::Center)
                        ->modalFooterActionsAlignment(Alignment::Center)
                        ->modalWidth(MaxWidth::TwoExtraLarge)
                        ->successNotificationTitle('Catégorie modifiée'),
                    DeleteAction::make()
                        ->button()
                        ->modalHeading('Suppression')
                        ->modalDescription('Êtes-vous sûr de vouloir supprimer cette catégorie ?')
                        ->modalCancelAction(/**
                         * @param StaticAction $action
                         * @return StaticAction
                         */ fn (StaticAction $action) => $action->color('info'))
                        ->modalSubmitActionLabel('Supprimer')
                        ->successNotificationTitle('Catégorie supprimée'),
                ]
            )
            ->paginated([10, 25, 50, 100, 'all']);
    }

    /**
     * Get the pages associated with the resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageCategories::route('/'),
        ];
    }
}
