<?php
namespace App\Nrna\Transformer;

use App\Nrna\Models\Update;
use League\Fractal\TransformerAbstract;

class CountryUpdateTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @param Update $update
     * @return array
     */
    public function transform(Update $update)
    {
        return [
            'id'          => (int) $update->id,
            'title'       => $update->title,
            'description' => $update->description,
            'created_at'  => $update->created_at->timestamp,
            'updated_at'  => $update->updated_at->timestamp
        ];
    }

}