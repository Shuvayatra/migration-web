<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

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

}
