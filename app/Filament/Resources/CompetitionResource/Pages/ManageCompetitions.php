<?php

namespace App\Filament\Resources\CompetitionResource\Pages;

use App\Filament\Resources\CompetitionResource;
use Filament\{Actions\Action,
    Actions\ActionGroup,
    Actions\CreateAction,
    Actions\StaticAction,
    Resources\Pages\ManageRecords,
    Support\Enums\Alignment,
    Support\Enums\MaxWidth};

class ManageCompetitions extends ManageRecords
{
    /**
     * The associated resource class for managing categories.
     *
     * @var string
     */
    protected static string $resource = CompetitionResource::class;

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
                ->modalHeading('Ajouter une compétition')
                ->modalSubmitActionLabel('Ajouter')
                ->modalCancelAction(/**
                 * @param StaticAction $action
                 * @return StaticAction
                 */ fn (StaticAction $action) => $action->color('danger'))
                ->modalSubmitActionLabel('Ajouter')
                ->icon('heroicon-m-plus-circle')
                ->modalAlignment(Alignment::Center)
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->modalFooterActionsAlignment(Alignment::Center)
                ->createAnother(false)
                ->successNotificationTitle('Compétition ajoutée'),
        ];
    }
}
