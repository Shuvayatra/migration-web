<?php

namespace App\Nrna\Models;

use App\Nrna\Services\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Screen
 * @package App\Nrna\Models
 */
class Screen extends Model
{
    use SortableTrait;
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'icon_image',
        'type',
        'visibility',
        'is_published',
        'position',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'visibility' => 'json',
    ];

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * @param $query
     * @param $gender
     *
     * @return mixed
     */
    public function scopeForGender($query, $gender)
    {
        return $query->whereIn(DB::raw("visibility->>'gender'"), [$gender, 'all']);
    }

    /**
     * @param       $query
     * @param array $countryIds
     *
     * @return mixed
     */
    public function scopeForCountry($query, array $countryIds)
    {
        return $query->whereIn(DB::raw("visibility->>'country'"), [$countryIds, null]);
    }

    public function getIconImagePathAttribute()
    {
        if ($this->icon_image == '') {
            return '';
        }

        return url('uploads/'.$this->icon_image);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'screen_feeds')->withPivot("category_type");
    }

    public function getApiMetadataAttribute()
    {
        $metadata = array_only(
            $this->toArray(),
            [
                'name',
                'title',
                'icon_image',
                'type',
            ]
        );

        $metadata['icon_image'] = $this->icon_image_path;

        return (object) $metadata;
    }

    public function getStateAttribute()
    {
        if ($this->is_published) {
            return config('screen.state.1');
        }

        return config('screen.state.0');
    }
}
