<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed created_at
 * @property mixed updated_at
 */
class Post extends Model
{

    /**
     * upload path for country
     */
    const UPLOAD_PATH = 'uploads/audio';

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
     * The answers that belongs to post.
     */
    public function answers()
    {
        return $this->belongsToMany('App\Nrna\Models\Answer');
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
        if (isset($metaData->data->audio)) {

            $metaData->data->audio = sprintf('%s/%s', url(Self::UPLOAD_PATH), $metaData->data->audio);
        }

        $metaData->source = urldecode($metaData->source);

        return $metaData;
    }

    /**
     * Convert json metadata to array
     *
     * @param $metaData
     * @return array
     */
    public function getApiMetadataAttribute()
    {
        $metadata = json_decode(json_encode($this->metadata), true);

        if (!is_array($metadata['stage'])) {
            $metadata['stage'] = (array) $metadata['stage'];
        }
        if ($metadata['type'] == 'text') {
            $metadata['data'] = array_only($metadata['data'], ['content']);
        }
        if ($metadata['type'] == 'video') {
            $metadata['data'] = array_only($metadata['data'], ['media_url', 'duration', 'thumbnail']);
        }

        if ($metadata['type'] == 'audio') {
            $metadata['data']['media_url'] = $metadata['data']['audio'];
            $metadata['data']              = array_only($metadata['data'], ['media_url', 'duration']);
        }

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

    /**
     * get audio name
     *
     * @return array
     */
    public function getAudioPathAttribute()
    {
        return sprintf(' % s /%s', public_path(Self::UPLOAD_PATH), $this->audioName);
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
