<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'answers';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'question_id'];

    /**
     * Get the question that owns the answer.
     */
    public function question()
    {
        return $this->belongsTo('App\Nrna\Models\Question');
    }

    /**
     * The posts that belongs to answer.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Nrna\Models\Post');
    }

    /**
     * @return timestamp
     */
    public function getDeletedAtAttribute()
    {
        return \Carbon::parse($this->attributes['deleted_at'])->timestamp;
    }
}
