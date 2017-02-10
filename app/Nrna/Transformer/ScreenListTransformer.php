<?php
namespace App\Nrna\Transformer;

use App\Nrna\Models\Screen;
use League\Fractal\TransformerAbstract;

/**
 * Class ScreenListTransformer
 * @package App\Nrna\Transformer
 */
class ScreenListTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @param Screen $screen
     *
     * @return array
     */
    public function transform(Screen $screen)
    {
        return [
            'id'       => (int) $screen->id,
            'title'    => $screen->title,
            'type'     => $screen->type,
            'order'    => $screen->order,
            'endpoint' => $screen->id,
            'icon'     => $screen->icon_image,
        ];
    }
}
