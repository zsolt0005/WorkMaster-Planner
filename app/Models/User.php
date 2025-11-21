<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $username
 * @property string $full_name
 * @property string $email
 * @property string $password
 */
final class User extends Authenticatable
{
    use Notifiable;

    public const string USERNAME = 'username';

    public const string EMAIL = 'email';

    public const string PASSWORD = 'password';

    /**
     * The attributes that are mass assignable.
     * *
     * * @var list<string>
     */
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()->whereHas('permissions', fn ($q) => $q->where('perm_name', $permission))->exists();
    }
}
