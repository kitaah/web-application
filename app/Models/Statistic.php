<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model};

class Statistic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'total_associations',
        'total_competitions',
        'total_games',
        'total_resources',
        'total_users',
    ];

    /**
     * Update the specified counter field in the statistics table.
     * @param $field
     * @param bool $increment
     */
    public static function updateCounter($field, bool $increment = true): void
    {
        $statistic = static::getStatistic();

        if (! $statistic->exists) {
            $statistic->$field = 1;
        } else {
            $increment ? $statistic->increment($field) : $statistic->decrement($field);
        }

        $statistic->save();
    }

    /**
     * Update the total number of associations.
     *
     * @return void
     */
    public static function updateAssociation(): void
    {
        static::updateCounter('total_associations');
    }

    /**
     * Update the total number of associations on delete.
     *
     * @return Statistic
     */
    public static function updateAssociationOnDelete(): Statistic
    {
        static::updateCounter('total_associations', false);
        return static::getStatistic();
    }

    /**
     * Update the total number of created competitions.
     *
     * @return void
     */
    public static function updateCreatedCompetition(): void
    {
        static::updateCounter('total_competitions');
    }

    /**
     * Update the total number of created competitions on delete.
     *
     * @return Statistic
     */
    public static function updateCreatedCompetitionOnDelete(): Statistic
    {
        static::updateCounter('total_competitions', false);
        return static::getStatistic();
    }

    /**
     * Update the total number of games.
     *
     * @return void
     */
    public static function updateGame(): void
    {
        static::updateCounter('total_games');
    }

    /**
     * Update the total number of games on delete.
     *
     * @return Statistic
     */
    public static function updateGameOnDelete(): Statistic
    {
        static::updateCounter('total_games', false);
        return static::getStatistic();
    }

    /**
     * Update the total number of resources.
     *
     * @return void
     */
    public static function updateResource(): void
    {
        static::updateCounter('total_resources');
    }

    /**
     * Update the total number of resources on delete.
     *
     * @return Statistic
     */
    public static function updateResourceOnDelete(): Statistic
    {
        static::updateCounter('total_resources', false);
        return static::getStatistic();
    }

    /**
     * Update the total number of users.
     *
     * @return void
     */
    public static function updateUser(): void
    {
        static::updateCounter('total_users');
    }

    /**
     * Update the total number of users on delete.
     *
     * @return Statistic
     */
    public static function updateUserOnDelete(): Statistic
    {
        static::updateCounter('total_users', false);
        return static::getStatistic();
    }

    /**
     * Retrieve the statistic model instance or create a new one if not exists.
     *
     * @return Statistic
     */
    public static function getStatistic(): Statistic
    {
        return static::firstOrNew([]);
    }
}
