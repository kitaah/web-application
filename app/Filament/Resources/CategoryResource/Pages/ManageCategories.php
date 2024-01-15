<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\{Actions\Action,
    Actions\ActionGroup,
    Actions\CreateAction,
    Actions\StaticAction,
    Resources\Pages\ManageRecords,
    Support\Enums\Alignment,
    Support\Enums\MaxWidth};

class ManageCategories extends ManageRecords
{
    /**
     * The associated resource class for managing categories.
     *
     * @var string
     */
    protected static string $resource = CategoryResource::class;

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
                ->modalHeading('Ajouter une catégorie')
                ->modalCancelAction(/**
                 * @param StaticAction $action
                 * @return StaticAction
                 */ fn (StaticAction $action) => $action
                    ->color('danger'))
                ->modalSubmitActionLabel('Ajouter')
                ->icon('heroicon-m-plus-circle')
                ->modalAlignment(Alignment::Center)
                ->modalFooterActionsAlignment(Alignment::Center)
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->modalSubmitActionLabel('Ajouter')
                ->createAnother(false)
                ->successNotificationTitle('Catégorie ajoutée'),
        ];
    }
}
