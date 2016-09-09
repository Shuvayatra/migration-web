<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SimilarPost
 * @package App\Nrna\Models
 */
class SimilarPost extends Model
{
    use softDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'similar_posts';
    /**
     * @var array
     */
    protected $fillable = ['post_id', "similar_post_id"];

    /**
     * @var bool
     */
    public $timestamps = false;

}

