<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rutorika\Sortable\SortableTrait;

class CategoryAttribute extends Model
{
    /**
     * upload path for place
     */
    const UPLOAD_PATH = 'uploads/section';
    use SoftDeletes;
    use SortableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_attributes';

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

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function subCategories()
    {
        return $this->hasMany(CategoryAttribute::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(CategoryAttribute::class, 'parent_id');
    }

    /**
     * @return timestamp
     */
    public function getDeletedAtAttribute()
    {
        return \Carbon::parse($this->attributes['deleted_at'])->timestamp;
    }

}
