<?php

namespace App\Nrna\Models;

use App\Nrna\Traits\UserInfoTrait;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use UserInfoTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notices';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $casts = ['metadata' => 'object'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['metadata', 'country_id', 'status'];

    public function getTitleAttribute()
    {
        return $this->metadata->title;
    }

    public function setCountryIdAttribute($value)
    {
        $this->attributes['country_id'] = empty($value) ? null : $value;
    }

    public function scopePublished($query)
    {
        return $query->where('status', true);
    }

    public function getApiMetadataAttribute()
    {
        $metadata              = json_decode(json_encode($this->metadata), true);
        $metadata['id']        = $this->id;
        $metadata['deeplink']  = isset($metadata['deeplink']) ? $metadata['deeplink'] : '';
        $metadata['image_url'] = sprintf('%s/%s', url('uploads/notice'), $this->metadata->image);

        return (object) $metadata;
    }
}
