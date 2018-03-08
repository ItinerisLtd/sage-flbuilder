<?php

namespace Itineris\SageFLBuilder\Modules\Button;

/**
 * Generic Bootstrap button widget
 *
 * @class Button
 */
class Button extends \FLBuilderModule
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
            'name'          => __('Button', 'fabric'),
            'description'   => __('Button widget', 'fabric'),
            'category'      => 'Actions',
            'group'         => FLBuilder::FAB_FL_MODULE_GROUP,
            'dir'           => __DIR__,
            'url'           => \App\asset_path(__DIR__),
            'icon'          => 'button.svg'
        ]);
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Button', [
    'general'       => [
        'title'         => 'Button',
        'sections'      => [
            'general'       => [
                'fields'        => [
                    'text'          => [
                        'type'          => 'text',
                        'label'         => __('Button text', 'fabric'),
                    ],
                    'link'          => [
                        'type'          => 'link',
                        'label'         => __('Button link', 'fabric'),
                    ],
                    'target'        => [
                        'type'          => 'select',
                        'label'         => __('Link target', 'fabric'),
                        'default'       => '_self',
                        'options'       => \App\link_targets()
                    ],
                    'style'         => [
                        'type'          => 'select',
                        'label'         => __('Button style', 'fabric'),
                        'default'       => 'btn-primary',
                        'options'       => \App\button_styles()
                    ]
                ],
            ],
        ],
    ],
]);
