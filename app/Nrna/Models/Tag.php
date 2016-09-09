<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'title_en', 'description'];

    /**
     * The question that belong to the tag.
     */
    public function questions()
    {
        return $this->belongsToMany('App\Nrna\Models\Question');
    }

    /**
     * The post that belong to the tag.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Nrna\Models\Post');
    }

    /**
     * sorted scope
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeSorted($query)
    {
        $field = \Input::has('s');
        $sort  = \Input::has('o');
        if ($field && $sort) {
            $columns = \Schema::getColumnListing($this->table);
            if (in_array($field, $columns)) {
                if ($sort === 'asc' || $sort === 'desc') {
                    return $query->orderBy($field, $sort);
                }
            }
        } else {
            return $query->orderBy('created_at', 'desc');
        }
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
        if (in_array(\Request::route()->getName(), ['tag.edit'])) {
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
}