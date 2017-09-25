<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @package App\Models
 * @property string $name
 * @property int $client_id
 */
class Repository extends Model {
    protected $table = 'client_repositories';

    public function owner()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
