<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'country';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'image', 'description'];

    /**
     * posts belongs to country
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Nrna\Models\PostS');
    }

}
