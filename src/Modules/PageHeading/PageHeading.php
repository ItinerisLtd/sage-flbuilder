<?php

namespace Itineris\SageFLBuilder\Modules\PageHeading;

/**
 * @class PageHeading
 */
class PageHeading extends \FLBuilderModule
{

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct([
            'name'          => __('Page heading', 'fabric'),
            'description'   => __('Page heading module', 'fabric'),
            'category'      => 'Basic',
            'group'         => FAB_FL_MODULE_GROUP,
            'dir'           => __DIR__,
            'url'           => \App\asset_path(__DIR__),
            'icon'          => 'text.svg'
        ]);
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Modules\PageHeading', [
    'general'        => [
        'title'       => __('Page Heading', 'fabric'),
        'sections'    => [
            'general'     => [
                'fields'      => [
                    'tag'         => [
                        'type'        => 'select',
                        'label'       => __('Heading type', 'fabric'),
                        'default'     => 'h1',
                        'options'     => [
                            'h1'          => __('Heading 1', 'fabric'),
                            'h2'          => __('Heading 2', 'fabric'),
                            'h3'          => __('Heading 3', 'fabric'),
                            'h4'          => __('Heading 4', 'fabric'),
                            'h5'          => __('Heading 5', 'fabric'),
                            'h6'          => __('Heading 6', 'fabric')
                        ]
                    ],
                    'title'       => [
                        'type'          => 'text',
                        'label'         => __('Title', 'fabric'),
                        'help'          => __('The title of this section', 'fabric')
                    ],
                    'text'        => [
                        'type'        => 'textarea',
                        'label'       => __('Main text', 'fabric'),
                        'rows'        => 5
                    ]
                ]
            ]
        ]
    ]
]);
