<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @property Form $form
 */
class Login extends BaseLogin
{
    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    /**
     * @return string|Htmlable
     */
    public function getHeading(): string|Htmlable
    {
        return __('Connexion');
    }

    /**
     * @return Component
     */
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email')
            ->placeholder('Email')
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->maxLength(50)
            ->suffixIcon('heroicon-m-at-symbol')
            ->suffixIconColor('danger')
            ->extraInputAttributes(['tabindex' => 1])
            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state));
    }

    /**
     * @return Component
     */
    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/login.form.password.label'))
            ->placeholder('Mot de passe')
            ->password()
            ->autocomplete('current-password')
            ->required()
            ->maxLength(255)
            ->suffixIcon('heroicon-m-key')
            ->suffixIconColor('danger')
            ->extraInputAttributes(['tabindex' => 2])
            ->dehydrateStateUsing(callback: fn (string $state) => htmlspecialchars($state));
    }
}
