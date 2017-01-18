<?php

namespace App\Nrna\Models;

use App\Nrna\Services\SortableTrait;
use App\Nrna\Traits\Json;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable;

class Block extends Model
{
    use SortableTrait;
    use Json;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blocks';
    /**
     * @var array
     */
    protected $jsonColumns = ['metadata', 'visibility'];
    /**
     * @var array
     */
    protected $casts = ['metadata' => 'object', 'visibility' => 'array'];


    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['metadata', 'page', 'position', 'show_country_id', 'visibility'];

    public function setShowCountryIdAttribute($show_country_id)
    {
        $this->attributes['show_country_id'] = ($show_country_id == '') ? null : $show_country_id;
    }

    /**
     * block api response format
     * @return array
     */
    public function getApiMetadataAttribute()
    {
        $metadata                 = json_decode(json_encode($this->metadata), true);
        $api_metadata             = array_only($metadata, ['layout', 'title', 'description']);
        $api_metadata['position'] = $this->position;

        if (in_array($this->metadata->layout, ['list', 'slider'])) {
            $api_metadata['content']            = $this->getContent();
            $api_metadata['view_more']          = (isset($this->metadata->show_view_more_flag) &&
                $this->metadata->show_view_more_flag == true) ? true : false;
            $api_metadata['view_more_title']    = ($api_metadata['view_more']) ? $this->metadata->show_view_more->title : '';
            $api_metadata['view_more_deeplink'] = ($api_metadata['view_more']) ? $this->metadata->show_view_more->url
                : '';
            $api_metadata['view_more_filter']   = array_map(
                function ($category_id) {
                    return (int) $category_id;
                },
                (array) $this->metadata->category_id
            );
        }

        return $api_metadata;
    }

    public function getNotice()
    {
        $query = Notice::published()->orderBy('created_at', 'desc');
        if ($this->page == "destination") {
            return $query->where('country_id', $this->metadata->country_id)->first();
        }
        if (request()->has('country_id')) {
            $query->where('country_id', request()->get('country_id'));
        } else {
            $query->where('country_id', null);
        }

        return $query->first();
    }

    /**
     * content form list and slider type layout
     * @return mixed
     */
    public function getContent()
    {
        $query = Post::select('*');
        $from  = 'posts ';
        if (isset($this->metadata->post_type) && !empty($this->metadata->post_type)) {
            $query_no = trim(str_repeat('?,', count($this->metadata->post_type)), ',');
            $query->whereRaw("posts.metadata->>'type' in ({$query_no})", $this->metadata->post_type);
        }

        if (isset($this->metadata->category_id)) {
            $category_ids = [];
            foreach ($this->metadata->category_id as $category) {
                $category       = Category::find($category);
                $category_ids[] = $category->getDescendantsAndSelf()->lists('id')->toArray();
            }
            $category_ids = array_unique(array_flatten($category_ids));
            $query->category($category_ids);
        }
        if (request()->has('country_id')) {
            $query->category(request()->get('country_id'));
        }
        $query->from(\DB::raw($from));
        $query->published();
        $query->limit($this->post_limit);

        return $query->get()->pluck('api_metadata');
    }

    /**
     * no of post for block
     * @return int
     */
    public function getPostLimitAttribute()
    {
        try {
            return $this->metadata->number_of_post;
        } catch (\Exception $e) {
            return 5;
        }
    }

    public function getTitleAttribute()
    {
        return isset($this->metadata->title) ? $this->metadata->title : '';
    }

    public function getLayoutAttribute()
    {
        return isset($this->metadata->layout) ? $this->metadata->layout : '';
    }

    /**
     * belongs to country
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->belongsTo(Category::class, "metadata->>'country_id'");
    }

    /**
     * belongs to journey
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function journey()
    {
        return $this->belongsTo(Category::class, "metadata->>'journey_id'");
    }

    /**
     * belongs to screen
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function screen()
    {
        return $this->belongsTo(Screen::class, "metadata->>'screen_id'");
    }

    /**
     * belongs to category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function show_country()
    {
        return $this->belongsTo(Category::class, 'show_country_id');
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

    public function scopePage($query, $page)
    {
        return $query->wherePage($page);
    }

}
