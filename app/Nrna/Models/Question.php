<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
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
     * Get the answers for the question.
     */
    public function answers()
    {
        return $this->hasMany('App\Nrna\Models\Answer');
    }

    public function subquestions()
    {
        return $this->hasMany('App\Nrna\Models\Question', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Nrna\Models\Question', 'parent_id');
    }

    /**
     * @return timestamp
     */
    public function getDeletedAtAttribute()
    {
        return \Carbon::parse($this->attributes['deleted_at'])->timestamp;
    }

    /**
     * Convert json metadata to array
     *
     * @param $metaData
     * @return array
     */
    public function getMetadataAttribute($metaData)
    {
        $metaData = json_decode($metaData);
        if (!$this->isParent()) {
            $metaData->language = $this->parent->metadata->language;
            $metaData->stage    = $this->parent->metadata->stage;
        }

        return $metaData;
    }

    public function isParent()
    {
        return ($this->parent_id == 0);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeParentOnly($query)
    {
        return $query->where('parent_id', '0');
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
        static::deleting(
            function ($question) {
                $question->answers()->delete();
            }
        );
    }
}
