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
     * Get Country image
     *
     * @param $image
     * @return string
     */
    public function getImageAttribute($image)
    {
        return sprintf('%s/%s', url(Self::UPLOAD_PATH), $image);
    }

    /**
     * Get Country image name
     *
     * @return string
     */
    public function getImageNameAttribute()
    {
        $array = explode('/', $this->image);

        return end($array);
    }

    /**
     * posts belongs to country
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Nrna\Models\Post');
    }

}
