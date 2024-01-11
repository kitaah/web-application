<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatisticResource\Pages\ManageStatistics;
use App\Models\Statistic;
use App\Policies\StatisticPolicy;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class StatisticResource extends Resource
{
    protected static ?string $model = Statistic::class;

    protected static ?string $navigationGroup = 'Gestion des statistiques';

    protected static ?string $navigationLabel = 'Statistiques';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $activeNavigationIcon = 'heroicon-s-chart-bar-square';

    /**
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema(components: [
                TextInput::make('total_associations')
                    ->label('Total associations')
                    ->required()
                    ->numeric()
                    ->suffixIcon('heroicon-m-building-storefront')
                    ->suffixIconColor('danger'),
                TextInput::make('total_competitions')
                    ->label('Total compétitions')
                    ->required()
                    ->numeric()
                    ->suffixIcon('heroicon-m-trophy')
                    ->suffixIconColor('danger'),
                TextInput::make('total_games')
                    ->label('Total jeux')
                    ->required()
                    ->numeric()
                    ->suffixIcon('heroicon-m-question-mark-circle')
                    ->suffixIconColor('danger'),
                TextInput::make('total_resources')
                    ->label('Total ressources')
                    ->required()
                    ->numeric()
                    ->suffixIcon('heroicon-m-rectangle-stack')
                    ->suffixIconColor('danger'),
                TextInput::make('total_users')
                    ->label('Total utilisateurs')
                    ->required()
                    ->numeric()
                    ->suffixIcon('heroicon-m-user-group')
                    ->suffixIconColor('danger'),
            ]);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->heading('Gestion des statistiques')
            ->description('Consultation et exportation des statistiques.')
            ->columns(components: [
                TextColumn::make('total_associations')
                    ->label('Total associations')
                    ->numeric()
                    ->alignCenter()
                    ->icon('heroicon-m-building-storefront')
                    ->iconColor('danger')
                    ->toggleable(),
                TextColumn::make('total_competitions')
                    ->label('Total compétitions')
                    ->numeric()
                    ->alignCenter()
                    ->icon('heroicon-m-trophy')
                    ->iconColor('danger')
                    ->toggleable(),
                TextColumn::make('total_games')
                    ->label('Total jeux')
                    ->numeric()
                    ->alignCenter()
                    ->icon('heroicon-m-question-mark-circle')
                    ->iconColor('danger')
                    ->toggleable(),
                TextColumn::make('total_resources')
                    ->label('Total ressources')
                    ->numeric()
                    ->alignCenter()
                    ->icon('heroicon-m-rectangle-stack')
                    ->iconColor('danger')
                    ->toggleable(),
                TextColumn::make('total_users')
                    ->label('Total utilisateurs')
                    ->numeric()
                    ->alignCenter()
                    ->icon('heroicon-m-user-group')
                    ->iconColor('danger')
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Mise à jour')
                    ->icon('heroicon-m-clock')
                    ->iconColor('danger')
                    ->dateTime(format: 'd-m-Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->toggleColumnsTriggerAction(
                callback: fn (Action $action) => $action
                    ->color('info')
                    ->label('Ajouter des colonnes'),
            )
            ->actions(actions: [
                ExportAction::make()
                    ->button()
                    ->label('Exporter')
                    ->color('success')
                    ->authorize(abilities: fn () => app(abstract: StatisticPolicy::class)->export(auth()->user(), new Statistic()))
                    ->exports([
                        ExcelExport::make()->fromTable()->except([
                            'updated_at',
                        ])->withFilename(fn ($resource) => $resource::getPluralLabel().date(' - d-m-Y')),
                    ]),
                EditAction::make()
                    ->color('warning')
                    ->successNotificationTitle('Statistiques modifiées'),
            ])
            ->persistFiltersInSession()
            ->paginated(condition: false);
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageStatistics::route('/'),
        ];
    }

    /**
     * @return string
     */
    public static function getPluralLabel(): string
    {
        return __(key: 'Statistiques');
    }

    /**
     * @return string
     */
    public static function getLabel(): string
    {
        return __(key: 'les statistiques');
    }
}
