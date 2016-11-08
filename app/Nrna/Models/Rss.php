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
    protected $fillable = ['title', 'url', 'category_id'];

    /**
     * belongs to category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(RssCategory::class);
    }

    /**
     * feeds of the rss
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeds()
    {
        return $this->hasMany(RssNewsFeeds::class);
    }

}
