<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
     * The tag that belongs to post.
     */
    public function tags()
    {
        return $this->belongsToMany('App\Nrna\Models\Tag');
    }

    /**
     * The country that belongs to post.
     */
    public function countries()
    {
        return $this->belongsToMany('App\Nrna\Models\Country');
    }

    /**
     * The questions that belongs to post.
     */
    public function questions()
    {
        return $this->belongsToMany('App\Nrna\Models\Question');
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
            function ($object) {
                $object->created_by = \Auth::User()->id;
                $object->updated_by = \Auth::User()->id;

                return true;
            }
        );
    }

}
