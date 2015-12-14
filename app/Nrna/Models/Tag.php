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
    protected $fillable = ['title'];

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

}
