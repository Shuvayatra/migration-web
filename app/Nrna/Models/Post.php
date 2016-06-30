<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed id
 * @property mixed created_at
 * @property mixed updated_at
 */
class Post extends Model
{
    use SoftDeletes;

    Const AUDIO = 'audio';
    Const VIDEO = 'video';
    Const TEXT = 'text';
    Const PLACE = 'place';

    Const DRAFT = 'draft';
    Const REVIEW = 'review';
    Const PUBLISHED = 'published';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * upload path for country
     */
    const UPLOAD_PATH = 'uploads/posts';

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
    protected $fillable = ['metadata', 'is_published'];

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
     * The country that belongs to post.
     */
    public function section_categories()
    {
        return $this->belongsToMany(CategoryAttribute::class);
    }

    /**
     * The category that belongs to post.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * The questions that belongs to post.
     */
    public function questions()
    {
        return $this->belongsToMany('App\Nrna\Models\Question');
    }

    /**
     * The answers that belongs to post.
     */
    public function answers()
    {
        return $this->belongsToMany('App\Nrna\Models\Answer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * Convert json metadata to array
     *
     * @param $metaData
     *
     * @return array
     */
    public function getMetadataWithPathAttribute()
    {
        $metadata = $this->metadata;
        if ($metadata->type == "text") {
            try {
                $metadata->data->file = $this->formatFile($this->metadata->data->file);
            } catch (\Exception $e) {
                return $e;
            }

        }

        if (isset($metadata->data->audio)) {
            $metadata->data->audio = sprintf('%s/%s', url(Self::UPLOAD_PATH), $metadata->data->audio);

            if (isset($metadata->data->thumbnail)) {
                $metadata->data->thumbnail = sprintf('%s/%s', url(Self::UPLOAD_PATH), $metadata->data->thumbnail);
            } else {
                $metadata->data->thumbnail = '';
            }
        }
        if (isset($metadata->featured_image) && $metadata->featured_image != '') {
            $metadata->featured_image = sprintf('%s/%s', url(self::UPLOAD_PATH), $metadata->featured_image);
        }

        //$metadata->stage  = (array) $metadata->stage;
        $metadata->source = urldecode($metadata->source);

        return $metadata;
    }

    public function audioUrl()
    {
        if (isset($this->metadata->data->audio_url) && $this->metadata->data->audio_url != "") {
            return $this->metadata->data->audio_url;
        }

        return $this->metadataWithPath->data->audio;
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
     *
     * @return array
     */
    public function getApiMetadataAttribute()
    {
        $metadata        = json_decode(json_encode($this->metadataWithPath), true);
        $metadata['share_url'] = sprintf('https://amp.shuvayatra.org/post/%s', $this->id);
        if ($metadata['type'] == 'text') {
            $metadata['data'] = array_only($metadata['data'], ['content', 'file']);
        }
        if ($metadata['type'] == 'video') {
            $metadata['data'] = array_only($metadata['data'], ['media_url', 'duration', 'thumbnail']);
        }

        if ($metadata['type'] == 'audio') {
            $metadata['data']['media_url'] = $metadata['data']['audio'];

            if (isset($metadata['data']['audio_url']) && $metadata['data']['audio_url'] != "") {
                $metadata['data']['media_url'] = $this->metadata->data->audio_url;
            }
            $metadata['data'] = array_only($metadata['data'], ['media_url', 'duration', 'thumbnail']);
        }
        unset($metadata['stage']);

        return $metadata;
    }

    /**
     * get audio name
     *
     * @return array
     */
    public function getAudioNameAttribute()
    {
        if (isset($this->metadata->data->audio)) {
            $array = explode("/", $this->metadata->data->audio);

            return end($array);
        }

        return '';
    }

    public function formatFile($files)
    {
        $returnArray = [];
        if (empty($files)) {
            return $returnArray;
        }
        foreach ($files as $file) {
            $file->file_name = sprintf('%s/%s', url(Self::UPLOAD_PATH), $file->file_name);
            $returnArray []  = $file;
        }

        return $returnArray;
    }

    /**
     * get audio name
     *
     * @return array
     */
    public function getAudioPathAttribute()
    {
        return sprintf('%s/%s', public_path(Self::UPLOAD_PATH), $this->audioName);
    }

    public function getFeaturedImageLinkAttribute()
    {
        if ($this->metadata->featured_image == '') {
            return null;
        }

        return sprintf('%s/%s', url(self::UPLOAD_PATH), $this->metadata->featured_image);
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

    /**
     * Scope a query to only include published post.
     *
     * @param $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereRaw("metadata->>'status'=?", [Self::PUBLISHED]);
    }

    public function getPostTypeIconAttribute()
    {
        if ($this->metadata->type == Self::AUDIO) {
            return 'fa-volume-up';
        }
        if ($this->metadata->type == Self::VIDEO) {
            return 'fa-video-camera';
        }
        if ($this->metadata->type == Self::PLACE) {
            return 'fa-plane';
        }
        if ($this->metadata->type == Self::TEXT) {
            return 'fa-file-text-o';
        }

        return '';
    }
}
