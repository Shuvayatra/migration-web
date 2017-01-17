<?php

namespace App\Nrna\Models;

use App\Nrna\Traits\Json;
use App\Nrna\Traits\UserInfoTrait;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use UserInfoTrait;
    use Json;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notices';

    protected $jsonColumns = ['screen'];

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $casts = ['metadata' => 'object', 'screen' => 'object'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['metadata', 'country_id', 'status', 'screen'];

    public function getTitleAttribute()
    {
        return $this->metadata->title;
    }

    public function setCountryIdAttribute($value)
    {
        $this->attributes['country_id'] = empty($value) ? null : $value;
    }

    public function setScreenAttribute($value)
    {
        if ($value['name'] == "home") {
            $value['screen_type'] = 'home';
        } else {
            $screen               = explode('-', $value['name']);
            $value['screen_type'] = $screen[0];
            $value['dynamic_id']  = $screen[1];
        }

        $this->attributes['screen'] = json_encode($value);
    }

    public function scopePublished($query)
    {
        return $query->where('status', true);
    }

    public function getApiMetadataAttribute()
    {
        $metadata             = json_decode(json_encode($this->metadata), true);
        $metadata['layout']   = 'notice';
        $metadata['id']       = $this->id;
        $metadata['deeplink'] = isset($metadata['deeplink']) ? $metadata['deeplink'] : '';
        if (isset($this->metadata->image) && $this->metadata->image != '') {
            $metadata['image_url'] = sprintf('%s/%s', url('uploads/notice'), $this->metadata->image);
        }

        return (object) $metadata;
    }

    public function country()
    {
        return $this->belongsTo(Category::class);
    }

    public function destination()
    {
        return $this->belongsTo(Category::class, "screen->>'dynamic_id'");
    }

    public function dynamic_screen()
    {
        return $this->belongsTo(Screen::class, "screen->>'dynamic_id'");
    }

    public function scopeScreen($query, $screen = 'home')
    {
        return $query->whereRaw("screen->>'screen_type' = ?", [$screen]);
    }
}
