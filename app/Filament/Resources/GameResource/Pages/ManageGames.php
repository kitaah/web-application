<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use App\Models\Statistic;
use Filament\{Actions\Action,
    Actions\ActionGroup,
    Actions\CreateAction,
    Actions\StaticAction,
    Resources\Pages\ManageRecords,
    Support\Enums\Alignment,
    Support\Enums\MaxWidth};

class ManageGames extends ManageRecords
{
    /**
     * The associated resource class for managing games.
     *
     * @var string
     */
    protected static string $resource = GameResource::class;

    /**
     * Get the header actions for the page.
     *
     * @return array|Action[]|ActionGroup[]
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->color('success')
                ->label('Ajouter')
                ->modalHeading('Ajouter un quiz')
                ->modalCancelAction(/**
                 * @param StaticAction $action
                 * @return StaticAction
                 */ fn (StaticAction $action) => $action->color('danger'))
                ->modalSubmitActionLabel('Ajouter')
                ->icon('heroicon-m-plus-circle')
                ->modalAlignment(Alignment::Center)
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalFooterActionsAlignment(Alignment::Center)
                ->createAnother(false)
                ->successNotificationTitle('Quiz ajouté')
                ->after(/**
                 * @return void
                 */ callback: function (): void {
                    Statistic::updateGame();
                }),
        ];
    }
}
