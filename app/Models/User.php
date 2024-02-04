<?php

namespace App\Models;

use Filament\{Models\Contracts\FilamentUser, Panel};
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Foundation\Auth\User as Authenticatable,
    Notifications\Notifiable};
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static count()
 * @method static find(int|string|null $userId)
 * @method static create(array $array)
 * @method static updateUserPoints(User|\Illuminate\Contracts\Auth\Authenticatable|null $user)
 * @property mixed $name
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'city',
        'email',
        'mood',
        'password',
        'terms_accepted',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'terms_accepted' => 'boolean',
    ];

    /**
     * Authorizing access to the admin panel
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['Super-Administrateur', 'Administrateur', 'Modérateur']);
    }
}
