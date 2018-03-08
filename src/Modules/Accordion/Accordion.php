<?php

namespace Itineris\SageFLBuilder\Modules\Accordion;

/**
 * Generic Bootstrap accordion widget
 *
 * @class Accordion
 */
class Accordion extends \FLBuilderModule
{
    public function __construct()
    {
        parent::__construct([
            'name'          => __('Accordion', 'fabric'),
            'description'   => __('Accordion widget', 'fabric'),
            'category'      => 'Layout',
            'group'         => FLBuilder::MODULE_GROUP,
            'dir'           => __DIR__,
            'url'           => \App\asset_path(__DIR__),
            'icon'          => 'layout.svg'
        ]);
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Modules\Accordion', [
    'items'         => [
        'title'         => __('Items', 'fabric'),
        'sections'      => [
            'general'       => [
                'title'         => '',
                'fields'        => [
                    'items'         => [
                        'type'          => 'form',
                        'label'         => __('Item', 'fabric'),
                        'form'          => 'accordion_items_form', // ID from registered form below
                        'preview_text'  => 'label', // Name of a field to use for the preview text
                        'multiple'      => true
                    ],
                    'collapsed'   => [
                        'type'        => 'select',
                        'label'       => __('Start collapsed?', 'fabric'),
                        'options'     => [
                            false       => __('No', 'fabric'),
                            true        => __('Yes', 'fabric')
                        ]
                    ]
                ]
            ]
        ]
    ]
]);

/**
 * Register a settings form to use in the "form" field type above.
 */
\FLBuilder::register_settings_form('accordion_items_form', [
    'title'         => __('Add Item', 'fabric'),
    'tabs'          => [
        'general'       => [
            'title'         => __('General', 'fabric'),
            'sections'      => [
                'general'       => [
                    'title'         => '',
                    'fields'        => [
                        'label'         => [
                            'type'          => 'text',
                            'label'         => __('Label', 'fabric')
                        ]
                    ]
                ],
                'content'       => [
                    'title'         => __('Content', 'fabric'),
                    'fields'        => [
                        'content'       => [
                            'type'          => 'editor',
                            'label'         => ''
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
