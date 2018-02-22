<?php

namespace App\Nrna\Models;

use Baum\Node;
use App\Nrna\Services\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Category extends Node
{
    use SortableTrait;
    use SoftDeletes;
    /**
     * upload path for place
     */
    const UPLOAD_PATH = 'uploads/category';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';
    /**
     * @var array
     */
    protected $casts = ['country_info' => 'object'];

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'title_en',
        'section',
        'description',
        'main_image',
        'icon',
        'small_icon',
        'position',
        'parent_id',
        'country_info',
        'status',
        'time_zone',
    ];

    public function getMainImageLinkAttribute()
    {
        if ($this->main_image == '') {
            return null;
        }

        return sprintf('%s/%s', url(self::UPLOAD_PATH), $this->main_image);
    }

    public function getIconLinkAttribute()
    {
        if ($this->icon == '') {
            return null;
        }

        return sprintf('%s/%s', url(self::UPLOAD_PATH), $this->icon);
    }

    public function getSmallIconLinkAttribute()
    {
        if ($this->small_icon == '') {
            return null;
        }

        return sprintf('%s/%s', url(self::UPLOAD_PATH), $this->small_icon);
    }

    public function getMainImagePathAttribute()
    {
        return sprintf('%s/%s', public_path(self::UPLOAD_PATH), $this->main_image);
    }

    public function getIconPathAttribute()
    {
        return sprintf('%s/%s', public_path(self::UPLOAD_PATH), $this->icon);
    }

    public function getSmallIconPathAttribute()
    {
        return sprintf('%s/%s', public_path(self::UPLOAD_PATH), $this->small_icon);
    }

    /**
     * @return timestamp
     */
    public function getDeletedAtAttribute()
    {
        return \Carbon::parse($this->attributes['deleted_at'])->timestamp;
    }

    /**
     * change title as user setting
     *
     * @param $title
     *
     * @return mixed
     */
    public function getTitleAttribute($title)
    {
        if (in_array(\Request::route()->getName(), ['category.edit'])) {
            return $title;
        }
        if (\Auth::guest()) {
            return $title;
        }

        if (\Auth::user()->language == 'en' && $this->title_en != '') {
            return $this->title_en;
        }

        return $title;
    }

    /**
     * change title as user setting
     *
     * @param $title
     *
     * @return mixed
     */
    public function getTitleEnAttribute($title)
    {
        if (in_array(\Request::route()->getName(), ['category.edit', 'category.show'])) {
            return $title;
        }
        if (in_array(\Request::route()->getName(), ['pushnotificationgroup.edit', 'pushnotificationgroup.create'])) {
            return $title;
        }
        if (\Auth::guest()) {
            return $title;
        }
        if (config()->has('country.'.$title)) {
            return config()->get('country.'.$title);
        }


        return $title;
    }

    public function scopePublished($query)
    {
        return $query->where('status', true);
    }
}
