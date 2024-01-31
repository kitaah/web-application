<?php

namespace App\Filament\Resources\ResourceResource\Pages;

use App\Filament\Resources\ResourceResource;
use Filament\{Actions\Action,
    Actions\ActionGroup,
    Actions\CreateAction,
    Actions\StaticAction,
    Resources\Pages\ManageRecords,
    Support\Enums\Alignment,
    Support\Enums\MaxWidth};
use App\Models\Statistic;

class ManageResources extends ManageRecords
{
    /**
     * The associated resource class for managing resources.
     *
     * @var string
     */
    protected static string $resource = ResourceResource::class;

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
                ->modalHeading('Ajouter une ressource')
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
                ->successNotificationTitle('Ressource ajoutée')
                ->after(/**
                 * @return void
                 */ callback: function (): void {
                    Statistic::updateResource();
                }),
        ];
    }
}
