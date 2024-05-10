<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatisticResource\Pages\ManageStatistics;
use App\Models\Statistic;
use App\Policies\StatisticPolicy;
use Filament\{Forms\Components\TextInput,
    Forms\Form,
    Resources\Resource,
    Tables\Actions\Action,
    Tables\Actions\EditAction,
    Tables\Columns\TextColumn,
    Tables\Table};
use pxlrbt\FilamentExcel\{Actions\Tables\ExportAction, Exports\ExcelExport};

class StatisticResource extends Resource
{
    /**
     * The model associated with the resource.
     *
     * @var string|null
     */
    protected static ?string $model = Statistic::class;

    /**
     * Get the plural label for the resource.
     *
     * @var string|null
     */
    protected static ?string $pluralLabel = 'Statistiques';

    /**
     * The slug used for this resource.
     *
     * @var string|null
     */
    protected static ?string $slug = 'statistiques';

    /**
     * Navigation group for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Gestion des statistiques';

    /**
     * Navigation label for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationLabel = 'Statistiques';

    /**
     * Navigation sort order for the resource.
     *
     * @var int|null
     */
    protected static ?int $navigationSort = 4;

    /**
     * Navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    /**
     * Active navigation icon for the resource.
     *
     * @var string|null
     */
    protected static ?string $activeNavigationIcon = 'heroicon-s-chart-bar-square';

    /**
     * Define the form structure for updating statistics.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        /** @var $form */
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
     * Define the table structure for listing statistics.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        /** @var $table */
        return $table
            ->heading('Gestion des statistiques')
            ->description('Consultation et exportation des statistiques au format Excel.')
            ->deferLoading()
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
            ])
            ->toggleColumnsTriggerAction(
            /**
             * @param Action $action
             * @return Action
             */ callback: fn (Action $action) => $action
                    ->color('info')
                    ->label('Ajouter des colonnes'),
            )
            ->actions(actions: [
                ExportAction::make()
                    ->button()
                    ->label('Exporter')
                    ->color('success')
                    ->authorize(/**
                     * @return bool
                     */ abilities: fn () => app(abstract: StatisticPolicy::class)->export(auth()->user(), new Statistic()))
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->except([
                            'updated_at',
                        ])->withFilename(/**
                         * @param $resource
                         * @return string
                         */ fn ($resource) => $resource::getPluralLabel().date(' - d-m-Y')),
                    ]),
            ])
            ->persistFiltersInSession()
            ->paginated(condition: false);
    }

    /**
     * Get the pages associated with the resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ManageStatistics::route('/'),
        ];
    }
}
