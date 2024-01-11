<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\ManageUsers;
use App\Models\User;
use Exception;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Rawilk\FilamentPasswordInput\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Gestion des comptes';

    protected static ?string $navigationLabel = 'Utilisateurs';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $activeNavigationIcon = 'heroicon-s-user-group';

    /**
     * @param Form $form
     * @return Form
     */
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
                    ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                TextInput::make('email')
                    ->placeholder('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->suffixIcon('heroicon-m-at-symbol')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                TextInput::make('password')
                    ->label('Mot de passe')
                    ->helperText('Au moins 8 caractères, une lettre majuscule, minuscule, un nombre et un caractère spécial.')
                    ->Regex("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{8,}$/")
                    ->password()
                    ->confirmed()
                    ->suffixIcon('heroicon-m-key')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(callback: fn (string $state) => Hash::make(htmlspecialchars($state)))
                    ->dehydrated(condition: fn (?string $state): bool => filled($state))
                    ->required(condition: fn (string $operation): bool => $operation === 'create'),
                TextInput::make('password_confirmation')
                    ->label('Confirmation du mot de passe')
                    ->password()
                    ->same('password')
                    ->suffixIcon('heroicon-m-key')
                    ->suffixIconColor('danger')
                    ->dehydrateStateUsing(callback: fn (string $state) => Hash::make(htmlspecialchars($state)))
                    ->dehydrated(condition: fn (?string $state): bool => filled($state))
                    ->required(condition: fn (string $operation): bool => $operation === 'create')
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
     * @param Table $table
     * @return Table
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
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
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('email')
                    ->icon('heroicon-m-at-symbol')
                    ->iconColor('danger')
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
                TextColumn::make('city')
                    ->label('Ville')
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('danger')
                    ->searchable()
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('roles.name')
                    ->label('Rôle')
                    ->icon('heroicon-m-finger-print')
                    ->iconColor('danger')
                    ->formatStateUsing(callback: fn (string $state) => htmlspecialchars($state)),
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
                callback: fn (Action $action) => $action
                    ->color('info')
                    ->label('Ajouter des colonnes'),
            )
            ->filters([
                SelectFilter::make('roles')
                    ->label('Rôles')
                    ->relationship('roles', 'name'),
            ])
            ->filtersTriggerAction(
                callback: fn (Action $action) => $action
                    ->color('danger')
                    ->label('Filtrer')
                    ->badgeColor('warning'),
            )
            ->actions([
                EditAction::make()
                    ->color('warning')
                    ->button()
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('danger'))
                    ->modalWidth(MaxWidth::ThreeExtraLarge)
                    ->modalAlignment(Alignment::Center)
                    ->modalFooterActionsAlignment(Alignment::Center)
                    ->successNotificationTitle('Utilisateur modifié'),
                DeleteAction::make()
                    ->button()
                    ->modalHeading('Suppression')
                    ->modalDescription('Êtes-vous sur de vouloir supprimer cet utilisateur ?')
                    ->modalCancelAction(fn (StaticAction $action) => $action->color('info'))
                    ->modalSubmitActionLabel('Supprimer')
                    ->successNotificationTitle('Utilisateur supprimé'),
            ])
            ->searchPlaceholder('Rechercher un utilisateur')
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
            'index' => ManageUsers::route('/'),
        ];
    }

    /**
     * @return string
     */
    public static function getPluralLabel(): string
    {
        return __(key: 'Utilisateurs');
    }

    /**
     * @return string
     */
    public static function getLabel(): string
    {
        return __(key: 'un utilisateur');
    }
}
