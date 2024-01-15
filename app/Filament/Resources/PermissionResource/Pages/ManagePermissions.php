<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\{Actions\Action,
    Actions\ActionGroup,
    Actions\CreateAction,
    Actions\StaticAction,
    Resources\Pages\ManageRecords,
    Support\Enums\Alignment,
    Support\Enums\MaxWidth};

class ManagePermissions extends ManageRecords
{
    /**
     * The associated resource class for managing permissions.
     *
     * @var string
     */
    protected static string $resource = PermissionResource::class;

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
                ->modalHeading('Ajouter une permission')
                ->modalCancelAction(/**
                 * @param StaticAction $action
                 * @return StaticAction
                 */ fn (StaticAction $action) => $action->color('danger'))
                ->modalSubmitActionLabel('Ajouter')
                ->icon('heroicon-m-plus-circle')
                ->modalAlignment(Alignment::Center)
                ->modalWidth(MaxWidth::Large)
                ->modalFooterActionsAlignment(Alignment::Center)
                ->createAnother(false)
                ->successNotificationTitle('Permission ajoutée'),
        ];
    }
}
