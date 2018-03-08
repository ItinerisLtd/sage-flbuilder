<?php

namespace App\Plugins\FLBuilder\Module\Table;

/**
 * Generic Bootstrap table widget
 *
 * @class Table
 */
class Table extends \FLBuilderModule
{
    public function __construct()
    {
        parent::__construct([
            'name'          => __('Table', 'fabric'),
            'description'   => __('Table module', 'fabric'),
            'category'      => 'Layout',
            'group'         => FLBuilder::FAB_FL_MODULE_GROUP,
            'dir'           => __DIR__,
            'url'           => \App\asset_path(__DIR__),
            'icon'          => 'editor-table.svg'
        ]);
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Module\Table', [
    'headers'       => [
        'title'         => __('Table Headers', 'fabric'),
        'sections'      => [
            'headers'       => [
                'fields'        => [
                    'headers'       => [
                        'type'          => 'text',
                        'label'         => __('Header', 'fabric'),
                        'multiple'      => true
                    ]
                ]
            ]
        ]
    ],
    'rows'          => [
        'title'         => __('Table Rows', 'fabric'),
        'sections'      => [
            'rows'          => [
                'fields'        => [
                    'rows'          => [
                        'type'          => 'form',
                        'label'         => __('Row', 'fabric'),
                        'form'          => 'table_row_form',
                        'preview_text'  => 'title',
                        'multiple'      => true
                    ]
                ]
            ]
        ]
    ]
]);

/**
 * Register the buttons settings form.
 */
\FLBuilder::register_settings_form('table_row_form', [
    'title'           => __('Row Settings', 'fabric'),
    'tabs'            => [
        'general'         => [
            'sections'        => [
                'general'         => [
                    'fields'          => [
                        'title'           => [
                            'type'            => 'text',
                            'label'           => __('Row label', 'fabric')
                        ],
                        'cell'            => [
                            'type'            => 'textarea',
                            'label'           => __('Cell', 'fabric'),
                            'multiple'        => true
                        ],
                        'enabled'         => [
                            'type'            => 'select',
                            'label'           => __('Visibility', 'fabric'),
                            'default'         => '1',
                            'options'         => [
                                '1'               => __('Show / Active', 'fabric'),
                                '0'               => __('Hide / Inactive', 'fabric')
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
