<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 * @package App\Models
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class Client extends Model {
    protected $table = 'clients';

    public function members()
    {
        return $this->belongsToMany(User::class, 'client_users')
            ->withPivot('role');
    }

    public function repositories()
    {
        return $this->hasMany(Repository::class, 'client_id');
    }
}
