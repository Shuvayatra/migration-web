<?php
namespace App\Nrna\Transformer;

use App\Nrna\Models\Country;
use League\Fractal\TransformerAbstract;

class CountryTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to includes via this processor
     *
     * @var array
     */
    protected $availableIncludes = [
        'updates'
    ];

    /**
     * @var array
     */
    protected $defaultIncludes = [
        'updates'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @param Country $country
     * @return array
     */
    public function transform(Country $country)
    {
        return [
            'id'          => (int) $country->id,
            'name'        => $country->name,
            'code'        => $country->code,
            'image'       => $country->image,
            'description' => $country->description,
            'created_at'  => $country->created_at->timestamp,
            'updated_at'  => $country->updated_at->timestamp
        ];
    }

    /**
     * Embed Updates
     *
     * @param Country $country
     * @return League\Fractal\Resource\Collection
     */
    public function includeUpdates(Country $country)
    {
        $updates = $country->updates;

        return $this->collection($updates, new CountryUpdateTransformer());
    }
}