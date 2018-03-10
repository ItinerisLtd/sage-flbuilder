<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\Accordion;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractModule;
use Itineris\SageFLBuilder\FLBuilderBase;
use function App\asset_path;

/**
 * Generic Bootstrap accordion widget
 *
 * @class Accordion
 */
class Accordion extends AbstractModule
{
    private const FORM_ID = 'accordion_items_form';

    /**
     * Register the module and its form settings and a settings form to use in the "form" field type.
     */
    public static function register(): void
    {
        FLBuilder::register_module(__CLASS__, [
            'items' => [
                'title' => __('Items', 'fabric'),
                'sections' => [
                    'general' => [
                        'title' => '',
                        'fields' => [
                            'items' => [
                                'type' => 'form',
                                'label' => __('Item', 'fabric'),
                                'form' => self::FORM_ID, // ID from registered form below
                                'preview_text' => 'label', // Name of a field to use for the preview text
                                'multiple' => true,
                            ],
                            'collapsed' => [
                                'type' => 'select',
                                'label' => __('Start collapsed?', 'fabric'),
                                'options' => [
                                    false => __('No', 'fabric'),
                                    true => __('Yes', 'fabric'),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        FLBuilder::register_settings_form(self::FORM_ID, [
            'title' => __('Add Item', 'fabric'),
            'tabs' => [
                'general' => [
                    'title' => __('General', 'fabric'),
                    'sections' => [
                        'general' => [
                            'title' => '',
                            'fields' => [
                                'label' => [
                                    'type' => 'text',
                                    'label' => __('Label', 'fabric'),
                                ],
                            ],
                        ],
                        'content' => [
                            'title' => __('Content', 'fabric'),
                            'fields' => [
                                'content' => [
                                    'type' => 'editor',
                                    'label' => '',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Accordion constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'name' => __('Accordion', 'fabric'),
            'description' => __('Accordion widget', 'fabric'),
            'category' => 'Layout',
            'group' => FLBuilderBase::MODULE_GROUP,
            'dir' => __DIR__,
            'url' => asset_path(__DIR__),
            'icon' => 'layout.svg',
        ]);
    }
}
