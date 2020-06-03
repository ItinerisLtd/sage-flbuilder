<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\Table;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\AbstractModule;
use function Roots\app as sage;

/**
 * Generic Bootstrap table widget
 *
 * @class Table
 */
class Table extends AbstractModule
{
    private const FORM_ID = 'table_row_form';

    public static function register(): void
    {
        FLBuilder::register_module(__CLASS__, [
            'headers' => [
                'title' => __('Table Headers', 'fabric'),
                'sections' => [
                    'headers' => [
                        'fields' => [
                            'headers' => [
                                'type' => 'text',
                                'label' => __('Header', 'fabric'),
                                'multiple' => true,
                            ],
                        ],
                    ],
                ],
            ],
            'rows' => [
                'title' => __('Table Rows', 'fabric'),
                'sections' => [
                    'rows' => [
                        'fields' => [
                            'rows' => [
                                'type' => 'form',
                                'label' => __('Row', 'fabric'),
                                'form' => self::FORM_ID,
                                'preview_text' => 'title',
                                'multiple' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        FLBuilder::register_settings_form(self::FORM_ID, [
            'title' => __('Row Settings', 'fabric'),
            'tabs' => [
                'general' => [
                    'sections' => [
                        'general' => [
                            'fields' => [
                                'title' => [
                                    'type' => 'text',
                                    'label' => __('Row label', 'fabric'),
                                ],
                                'cell' => [
                                    'type' => 'textarea',
                                    'label' => __('Cell', 'fabric'),
                                    'multiple' => true,
                                ],
                                'enabled' => [
                                    'type' => 'select',
                                    'label' => __('Visibility', 'fabric'),
                                    'default' => '1',
                                    'options' => [
                                        '1' => __('Show / Active', 'fabric'),
                                        '0' => __('Hide / Inactive', 'fabric'),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function __construct()
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        parent::__construct([
            'name' => __('Table', 'fabric'),
            'description' => __('Table module', 'fabric'),
            'category' => 'Layout',
            'group' => $helper->getModuleGroup(),
            'dir' => __DIR__,
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'editor-table.svg',
        ]);
    }
}
