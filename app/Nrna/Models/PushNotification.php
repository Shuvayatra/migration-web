<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pushnotifications';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'type', 'content_id', 'response'];
    
}
