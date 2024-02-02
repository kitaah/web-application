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

    /**
     * Generic method to delete a model, trigger the deletion update methods, and any additional update methods.
     *
     * @param int $id
     * @param string $modelClass
     * @param string ...$updateMethods
     * @return void
     */
    public function deleteModel(int $id, string $modelClass, ...$updateMethods): void
    {
        $modelClass::destroy($id);

        foreach ($updateMethods as $updateMethod) {
            self::$updateMethod();
        }
    }

    /**
     * Delete an Association model and trigger the associated update method.
     *
     * @param int $id
     * @return void
     */
    public function deleteAssociation(int $id): void
    {
        $this->deleteModel($id, Association::class, 'updateAssociationOnDelete');
    }

    /**
     * Delete a Competition model and trigger the associated update method.
     *
     * @param int $id
     * @return void
     */
    public function deleteCompetition(int $id): void
    {
        $this->deleteModel($id, Competition::class, 'updateCreatedCompetitionOnDelete');
    }

    /**
     * Delete a Category model and trigger the associated update methods.
     *
     * @param int $id
     * @return void
     */
    public function deleteCategory(int $id): void
    {
        $this->deleteModel($id, Category::class, 'updateResourceOnDelete', 'updateAssociationOnDelete');
    }

    /**
     * Delete a User model and trigger the associated update method.
     *
     * @param int $id
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $this->deleteModel($id, User::class, 'updateResourceOnDelete');
    }
}
