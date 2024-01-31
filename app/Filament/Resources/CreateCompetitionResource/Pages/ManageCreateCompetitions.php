<?php

namespace App\Filament\Resources\CreateCompetitionResource\Pages;

use App\Filament\Resources\CreateCompetitionResource;
use Filament\Actions\{Action, ActionGroup, CreateAction, StaticAction};
use App\Models\Statistic;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;

class ManageCreateCompetitions extends ManageRecords
{
    /**
     * The associated resource class for managing competition organizations.
     *
     * @var string
     */
    protected static string $resource = CreateCompetitionResource::class;

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
                ->modalHeading('Ajouter une planification')
                ->modalCancelAction(/**
                 * @param StaticAction $action
                 * @return StaticAction
                 */ fn (StaticAction $action) => $action->color('danger'))
                ->modalSubmitActionLabel('Ajouter')
                ->icon('heroicon-m-plus-circle')
                ->modalAlignment(Alignment::Center)
                ->modalWidth(MaxWidth::ThreeExtraLarge)
                ->modalFooterActionsAlignment(Alignment::Center)
                ->createAnother(false)
                ->successNotificationTitle('Planification ajoutée')
                ->after(/**
                 * @return void
                 */ callback: function (): void {
                    Statistic::updateCreatedCompetition();
                }),
        ];
    }
}
