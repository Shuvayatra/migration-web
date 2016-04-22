<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class Rss extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rss';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'url'];

}
