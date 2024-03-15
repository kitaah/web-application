<?php

namespace App\Filament\Pages\Auth;

use Filament\{Forms\Components\Component, Forms\Components\TextInput, Forms\Form, Pages\Auth\Login as BaseLogin};
use Illuminate\Contracts\{Support\Htmlable};
use Illuminate\Validation\{Rule};

/**
 * @property Form $form
 */
class Login extends BaseLogin
{
    /**
     * Define the form structure for the login page.
     *
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        /** @var $form */
        return $form
            ->schema(components: [
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    /**
     * Get the heading for the login page.
     *
     * @return string|Htmlable
     */
    public function getHeading(): string|Htmlable
    {
        return __(/** @lang text */ 'Connexion');
    }

    /**
     * Get the email form component.
     *
     * @return Component
     */
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email')
            ->placeholder('Email')
            ->email()
            ->required()
            ->rules([
                Rule::exists('users', 'email'),
            ])
            ->validationMessages([
                'exists'   => 'Informations de saisies incorrectes.',
            ])
            ->autocomplete()
            ->autofocus()
            ->maxLength(50)
            ->suffixIcon('heroicon-m-at-symbol')
            ->suffixIconColor('danger')
            ->extraInputAttributes(['tabindex' => 1])
            ->dehydrateStateUsing(/**
             * @param string $state
             * @return string
             */ callback: fn (string $state) => htmlspecialchars($state));
    }

    /**
     * Get the password form component.
     *
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
            ->Regex("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{8,}$/")
            ->validationMessages([
                'regex' => 'Informations de saisies incorrectes.',
            ])
            ->maxLength(255)
            ->suffixIcon('heroicon-m-key')
            ->suffixIconColor('danger')
            ->extraInputAttributes(['tabindex' => 2])
            ->dehydrateStateUsing(/**
             * @param string $state
             * @return string
             */ callback: fn (string $state) => htmlspecialchars($state));
    }
}
