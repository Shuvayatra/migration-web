<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Update extends Model
{

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'country_updates';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'country_id'];

    /**
     * @return timestamp
     */
    public function getDeletedAtAttribute()
    {
        return \Carbon::parse($this->attributes['deleted_at'])->timestamp;
    }

    /**
     * get country belong to updates
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo("App\Nrna\Models\Country");
    }
}
