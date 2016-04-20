<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'places';

    /**
     * @var array
     */
    protected $casts = ['metadata' => 'object'];

    /**
     * upload path for place
     */
    const UPLOAD_PATH = 'uploads/place';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['metadata', 'image', 'status', 'country_id'];

    public function country()
    {
        return $this->belongsTo('App\Nrna\Models\Country');
    }

    public function getImageLinkAttribute()
    {
        return sprintf('%s/%s', url(self::UPLOAD_PATH), $this->image);
    }

    public function getImagePathAttribute()
    {
        return sprintf('%s/%s', public_path(self::UPLOAD_PATH), $this->image);
    }
}
