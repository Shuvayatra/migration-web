<?php
return [
    'entities' => [
        'journey'          => '\App\Nrna\Models\Journey',
        'journey_category' => '\App\Nrna\Models\JourneySubcategory',
        'section_category' => '\App\Nrna\Models\CategoryAttribute',
        'category'         => '\App\Nrna\Models\Category',
        'block'            => 'App\Nrna\Models\Block',
        'block_posts'      => [
            'entity'   => '\App\Nrna\Models\Block',
            'relation' => 'custom_posts' // relation name (method name which returns $this->belongsToSortedMany)
        ],
        'screen'           => '\App\Nrna\Models\Screen',
        // 'articles' => ['entity' => '\Article', 'relation' => 'tags'] for many to many or many to many polymorphic relation sorting
    ],
];
