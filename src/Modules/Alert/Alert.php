<?php

namespace App\Plugins\FLBuilder\Modules;

/**
 * Class Alert
 */
class Alert extends \FLBuilderModule
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
            'name'          => __('Alert', 'fabric'),
            'description'   => __('Alert widget', 'fabric'),
            'category'      => 'Actions',
            'group'         => FAB_FL_MODULE_GROUP,
            'dir'           => __DIR__,
            'url'           => \App\asset_path(__DIR__),
            'icon'          => 'megaphone.svg'
        ]);
    }
}

\FLBuilder::register_module('\App\Plugins\FLBuilder\Modules\Alert', [
    'general'       => [
        'title'         => __('Alert settings', 'fabric'),
        'sections'      => [
            'general'       => [
                'fields'        => [
                    'text'          => [
                        'type'          => 'editor',
                        'label'         => __('Text', 'fabric'),
                        'default'       => 'active giving scroller recognition as well.',
                        'media_buttons' => false
                    ],
                    'style'         => [
                        'type'          => 'select',
                        'label'         => __('Style', 'fabric'),
                        'default'       => 'alert-success',
                        'options'       => [
                            'alert-success' => __('Success', 'fabric'),
                            'alert-info'    => __('Info', 'fabric'),
                            'alert-warning' => __('Warning', 'fabric'),
                            'alert-danger'  => __('Danger', 'fabric')
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
