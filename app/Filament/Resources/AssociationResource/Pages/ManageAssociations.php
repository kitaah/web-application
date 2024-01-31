<?php

namespace App\Filament\Resources\AssociationResource\Pages;

use App\Filament\Resources\AssociationResource;
use Filament\{Actions\Action,
    Actions\ActionGroup,
    Actions\CreateAction,
    Actions\StaticAction,
    Resources\Pages\ManageRecords,
    Support\Enums\Alignment};
use App\Models\Statistic;

class ManageAssociations extends ManageRecords
{
    /**
     * The associated resource class for managing associations.
     *
     * @var string
     */
    protected static string $resource = AssociationResource::class;

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
                ->modalHeading('Ajouter une association')
                ->modalCancelAction(/**
                 * @param StaticAction $action
                 * @return StaticAction
                 */ fn (StaticAction $action) => $action
                    ->color('danger'))
                ->modalSubmitActionLabel('Ajouter')
                ->icon('heroicon-m-plus-circle')
                ->modalAlignment(Alignment::Center)
                ->modalFooterActionsAlignment(Alignment::Center)
                ->createAnother(false)
                ->successNotificationTitle('Association ajoutée')
                ->after(/**
                 * @return void
                 */ callback: function (): void {
                    Statistic::updateAssociation();
                }),
        ];
    }
}
