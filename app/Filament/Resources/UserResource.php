<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\ManageUsers;
use App\Models\User;
use Exception;
use Filament\{Actions\StaticAction,
    Forms\Components\DateTimePicker,
    Forms\Components\Hidden,
    Forms\Components\Select,
    Forms\Components\TextInput,
    Forms\Form,
    Resources\Resource,
    Support\Enums\Alignment,
    Support\Enums\MaxWidth,
    Tables\Actions\Action,
    Tables\Actions\DeleteAction,
    Tables\Actions\EditAction,
    Tables\Columns\IconColumn,
    Tables\Columns\TextColumn,
    Tables\Filters\SelectFilter,
    Tables\Table};
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = User::class;

    /**
     * The slug used for this resource.
     *
     * @var string|null
     */
    protected static ?string $slug = 'utilisateurs';

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
    protected static ?string $navigationLabel = 'Utilisateurs';

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
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-user-group';

    /**
     * Define the form structure for creating and updating users.
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
                    ->dehydrateStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
                TextInput::make('email')
                    ->placeholder('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->suffixIcon('heroicon-m-at-symbol')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
                TextInput::make('password')
                    ->label('Mot de passe')
                    ->helperText('Au moins 8 caractères, une lettre majuscule, minuscule, un nombre et un caractère spécial.')
                    ->Regex("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{8,}$/")
                    ->password()
                    ->confirmed()
                    ->suffixIcon('heroicon-m-key')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => Hash::make(htmlspecialchars($state)))
                    ->dehydrated(/**
                     * @param string|null $state
                     * @return bool
                     */ condition: fn (?string $state): bool => filled($state))
                    ->required(/**
                     * @param string $operation
                     * @return bool
                     */ condition: fn (string $operation): bool => $operation === 'create'),
                TextInput::make('password_confirmation')
                    ->label('Confirmation du mot de passe')
                    ->password()
                    ->same('password')
                    ->suffixIcon('heroicon-m-key')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => Hash::make(htmlspecialchars($state)))
                    ->dehydrated(/**
                     * @param string|null $state
                     * @return bool
                     */ condition: fn (?string $state): bool => filled($state))
                    ->required(/**
                     * @param string $operation
                     * @return bool
                     */ condition: fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255),
                Hidden::make('terms_accepted')
                    ->default(true),
                Select::make('roles')
                    ->label('Rôle')
                    ->placeholder('Sélectionnez un rôle')
                    ->required()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->suffixIcon('heroicon-m-finger-print')
                    ->suffixIconColor('danger'),
                DateTimePicker::make('email_verified_at')
                    ->label('Date de vérification de l\'email'),
            ]);
    }

    /**
     * Define the table structure for listing users.
     *
     * @param Table $table
     * @return Table
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
        return $table
            ->heading('Gestion des utilisateurs')
            ->description('Listing, ajout, modification et suppression d\'utilisateurs.')
            ->deferLoading()
            ->columns(components: [
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('email')
                    ->icon('heroicon-m-at-symbol')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('city')
                    ->label('Ville')
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('danger')
                    ->searchable()
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('roles.name')
                    ->label('Rôle')
                    ->icon('heroicon-m-finger-print')
                    ->iconColor('danger')
                    ->formatStateUsing(/**
                     * @param string $state
                     * @return string
                     */ callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('mood')
                    ->label('Humeur')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('terms_accepted')
                    ->label('Acceptation des CGU')
                    ->alignCenter()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email_verified_at')
                    ->label('Vérification de l\'email')
                    ->dateTime('d-m-Y H:i:s')
                    ->icon('heroicon-m-check-circle')
                    ->iconColor('danger')
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
            ->filters([
                SelectFilter::make('roles')
                    ->label('Rôles')
                    ->relationship('roles', 'name'),
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
                    ->modalWidth(MaxWidth::ThreeExtraLarge)
                    ->modalAlignment(Alignment::Center)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->successNotificationTitle('Utilisateur modifié'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sur de vouloir supprimer cet utilisateur ?')
                    ->modalCancelAction(/**
                     * @param StaticAction $action
                     * @return StaticAction
                     */ fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Utilisateur supprimé'),
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
            'index' => ManageUsers::route('/'),
        ];
    }

    /**
     * Get the plural label for the resource.
     *
     * @return string
     */
    public static function getPluralLabel(): string
    {
        return __(key: /** @lang text */ 'Utilisateurs');
    }

    /**
     * Get the singular label for the resource.
     *
     * @return string
     */
    public static function getLabel(): string
    {
        return __(key: /** @lang text */ 'un utilisateur');
    }
}
