<?php

namespace Itineris\SageFLBuilder\Modules\Video;

/**
 * Class Video
 */
class Video extends \FLBuilderModule
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
            'name'          => __('Video', 'fabric'),
            'description'   => __('Video Widget', 'fabric'),
            'category'      => FLBuilder::FAB_FL_MODULE_CAT,
            'dir'           => __DIR__,
            'url'           => \App\asset_path(__DIR__),
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ]);
        
        $this->add_js('jquery-magnificpopup');
        $this->add_css('jquery-magnificpopup');
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Modules\Video', [
    'general'       => [
        'title'         => __('Video', 'fabric'),
        'sections'      => [
            'general'       => [
                'fields'        => [
                    'source'        => [
                        'type'          => 'select',
                        'label'         => __('Video source', 'fabric'),
                        'options'       => [
                            'module'    => __('Module', 'fabric'),
                            'custom'    => __('Custom', 'fabric'),
                        ],
                        'toggle'        => [
                            'module'        => [
                                'sections'      => ['module']
                            ],
                            'custom'        =>  [
                                'sections'      => ['custom']
                            ]
                        ]
                    ],
                    'thumbnail'     => [
                        'type'          => 'photo',
                        'label'         => __('Custom thumbnail', 'fabric'),
                        'show_remove'   => true
                    ]
                ]
            ],
            'module'        => [
                'fields'        => [
                    'module'        => [
                        'type'          => 'select',
                        'label'         => __('Video', 'fabric'),
                        'options'       => (\FLBuilderModel::is_builder_active()) ? \App\get_posts('video') : []
                    ],
                ]
            ],
            'custom'        => [
                'fields'        => [
                    'custom'        => [
                        'type'          => 'link',
                        'label'         => __('Video', 'fabric')
                    ]
                ]
            ]
        ]
    ]
]);
