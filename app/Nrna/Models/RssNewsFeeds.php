<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class RssNewsFeeds extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rssnewsfeeds';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['rss_id', 'title', 'description', 'image', 'permalink', 'post_date'];

    public function rss()
    {
        return $this->belongsTo(Rss::class, 'rss_id');
    }

    public function getRadioItemAttribute()
    {
        $metadata['title']       = $this->title;
        $metadata['description'] = html_entity_decode($this->description);
        $metadata['source']      = $this->permalink;
        $metadata['image']       = $this->image;
        $metadata['post_date']   = $this->post_date;
        $metadata['created_at']  = $this->created_at->timestamp;

        return $metadata;
    }

}
