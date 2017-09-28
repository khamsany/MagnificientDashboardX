<?php

namespace App;

use App\Models\Client;
use App\Models\ClientUser;
use App\Models\Repository;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    protected $scopeId;

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function repositories()
    {
        return $this->hasManyThrough(Repository::class, ClientUser::class, 'user_id', 'client_id', 'id', 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(Client::class, 'client_users')
            ->withPivot('role');
    }

    public function scopeWithIdentity($query, $userId)
    {
        $this->scopeId = $userId;
        $query->with([
            'repositories' => function ($query) {
                $query->with([
                    'owner' => function ($query) {
                        $query->with([
                            'members' => function ($query) {
                                $query->withPivot('role');
                                $query->wherePivot('user_id', $this->scopeId);
                            }
                        ]);
                    }
                ]);
            }
        ]);
    }
}
