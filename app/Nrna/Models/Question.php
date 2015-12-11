<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * @var array
     */
    protected $casts = ['metadata' => 'object'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['metadata'];

    /**
     * The tag that belongs to question.
     */
    public function tags()
    {
        return $this->belongsToMany('App\Nrna\Models\Tag');
    }

    /**
     * The post that belongs to question.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Nrna\Models\Post');
    }

    /**
     * Boot the  model
     * Attach event listener to add user creating a model
     *
     * @return void|bool
     */
    public static function boot()
    {
        parent::boot();
        static::creating(
            function ($question) {
                $question->created_by = Auth::User()->id;
                $question->updated_by = Auth::User()->id;

                return true;
            }
        );
    }

}
