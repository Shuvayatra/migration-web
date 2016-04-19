<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journey extends Model
{

    use SoftDeletes;
    use \Rutorika\Sortable\SortableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'journeys';

    /**
     * upload path for country
     */
    const UPLOAD_PATH = 'uploads/journey';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'menu_image', 'featured_image', 'small_menu_image', 'position', 'status'];

    public function getFeaturedImageLinkAttribute()
    {
        return sprintf('%s/%s', url(self::UPLOAD_PATH), $this->featured_image);
    }

    public function getMenuImageLinkAttribute()
    {
        return sprintf('%s/%s', url(self::UPLOAD_PATH), $this->menu_image);
    }

    public function getSmallMenuImageLinkAttribute()
    {
        return sprintf('%s/%s', url(self::UPLOAD_PATH), $this->small_menu_image);
    }

    public function getFeaturedImagePathAttribute()
    {
        return sprintf('%s/%s', public_path(self::UPLOAD_PATH), $this->featured_image);
    }

    public function getMenuImagePathAttribute()
    {
        return sprintf('%s/%s', public_path(self::UPLOAD_PATH), $this->menu_image);
    }

    public function getSmallMenuImagePathAttribute()
    {
        return sprintf('%s/%s', public_path(self::UPLOAD_PATH), $this->small_menu_image);
    }

    public function subCategories()
    {
        return $this->hasMany('App\Nrna\Models\JourneySubcategory')->sorted();
    }
}
