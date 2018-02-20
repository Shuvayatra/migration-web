<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotificationGroup extends Model
{
    /**
     * Attributes that should not be mass-assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'push_notification_groups';

    /**
     * The notifications sent to the group.
     */
    public function notifications()
    {
        return $this->belongsToMany('App\Nrna\Models\PushNotification');
    }
}
