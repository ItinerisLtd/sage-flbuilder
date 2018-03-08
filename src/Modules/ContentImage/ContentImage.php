<?php

namespace App\Plugins\FLBuilder\Modules;

/**
 * Generic Bootstrap button widget
 *
 * @class ContentImage
 */
class ContentImage extends \FLBuilderModule
{
    public function __construct()
    {
        parent::__construct([
            'name'          => __('Content image', 'fabric'),
            'description'   => __('Content image widget', 'fabric'),
            'category'      => 'Media',
            'group'         => FAB_FL_MODULE_GROUP,
            'dir'           => __DIR__,
            'url'           => \App\asset_path(__DIR__),
            'icon'          => 'format-image.svg'
        ]);
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Modules\ContentImage', [
    'general'       => [
        'title'         => 'Image',
        'sections'      => [
            'general'       => [
                'fields'        => [
                    'image'         => [
                        'type'          => 'photo',
                        'label'         => __('Image', 'fabric'),
                        'show_remove'   => false
                    ]
                ]
            ]
        ]
    ]
]);
