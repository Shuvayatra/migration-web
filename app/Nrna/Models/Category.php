<?php

namespace App\Nrna\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Node
{
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
        'description',
        'main_image',
        'icon',
        'small_icon',
        'position',
        'section_id',
        'parent_id',
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
}
