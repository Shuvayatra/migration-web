<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sections';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'section', 'is_locked'];

    protected function categories()
    {
        return $this->hasMany(CategoryAttribute::class)->where('parent_id', 0);
    }

    protected function subCategories()
    {
        return $this->hasMany(CategoryAttribute::class)->where('parent_id', '!=', 0);
    }

    /**
     * @return timestamp
     */
    public function getDeletedAtAttribute()
    {
        return \Carbon::parse($this->attributes['deleted_at'])->timestamp;
    }

}
