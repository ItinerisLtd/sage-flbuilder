<?php

namespace App\Plugins\FLBuilder\Modules;

/**
 * Generic Testimonial widget
 *
 * @class Testimonial
 */
class Testimonial extends \FLBuilderModule
{
    public function __construct()
    {
        parent::__construct([
            'name'          => __('Testimonial', 'fabric'),
            'description'   => __('Testimonial widget', 'fabric'),
            'category'      => 'Media',
            'group'         => FAB_FL_MODULE_GROUP,
            'dir'           => __DIR__,
            'url'           => \App\asset_path(__DIR__),
            'icon'          => 'format-quote.svg'
        ]);
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Modules\Testimonial', [
    'general'       => [
        'title'         => 'Image',
        'sections'      => [
            'general'       => [
                'fields'        => [
                    'text'          => [
                        'type'          => 'textarea',
                        'label'         => __('Text', 'fabric'),
                        'rows'          => 4
                    ],
                    'cite_1'        => [
                        'type'          => 'text',
                        'label'         => __('Cite 1', 'fabric')
                    ],
                    'cite_2'        => [
                        'type'          => 'text',
                        'label'         => __('Cite 2', 'fabric')
                    ]
                ]
            ]
        ]
    ]
]);
