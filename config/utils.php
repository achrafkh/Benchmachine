<?php

return [
    'charts' => [
        'totalFans' => [
            'id' => 1,
            'title' => 'Total fans number',
            'title_en' => true, // title enabled
            'label' => 'Total Fans',
            'field' => 'fans',
        ],
        'fansVariation' => [
            'id' => 2,
            'title' => 'Fans number variation',
            'title_en' => true,
            'label' => 'Fans Variation',
            'field' => 'absolute_fans',
        ],
        'interactions' => [
            'id' => 3,
            'title' => 'Interactions',
            'title_en' => true,
            'label' => 'Interactions',
            'field' => 'interactions',
        ],
        'averageEngagementRate' => [
            'id' => 4,
            'title' => 'Page average engagement rate',
            'title_en' => true,
            'label' => 'Average engagement rate',
            'field' => 'average_page_engagement',
        ],
    ],
    'colors' => ["#36A2EB", "#FF6384", "#FFCD56", "#4BC0C0", "#FB761D", "#7584D9", '#A4DC63', '#FFC107', '#74909D', '#FF7BAB'],
    'tag' => 'custom_benchmark',
];
