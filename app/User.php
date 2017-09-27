<?php

namespace App;

use App\Models\Client;
use App\Models\ClientUser;
use App\Models\Repository;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    public function repositories()
    {
        return $this->hasManyThrough(Repository::class, ClientUser::class, 'user_id', 'client_id', 'id', 'client_id');
    }

    public function scopeInfo($query)
    {
        $query->with('repositories');
    }
}
