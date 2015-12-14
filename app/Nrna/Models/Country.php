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
     * upload path for country
     */
    const UPLOAD_PATH = 'uploads/country';

    /**
     * Get question Title
     *
     * @return string
     */
    public function getFilePathAttribute()
    {
        return public_path(sprintf('%s/%s', Self::UPLOAD_PATH, $this->image));
    }


    /**
     * posts belongs to country
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Nrna\Models\PostS');
    }

}
