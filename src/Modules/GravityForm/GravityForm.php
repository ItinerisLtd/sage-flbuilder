<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\GravityForm;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractBladeModule;
use Itineris\SageFLBuilder\AbstractHelper;
use function App\sage;

class GravityForm extends AbstractBladeModule
{
    /**
     * Register the module and its form settings.
     * If needed, register a settings form to use in the "form" field type.
     */
    public static function register(): void
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        FLBuilder::register_module(__CLASS__, [
            'items' => [
                'title' => __('Gravity Form', 'fabric'),
                'sections' => [
                    'general' => [
                        'fields' => [
                            'title' => [
                                'type' => 'text',
                                'label' => __('Title', 'fabric'),
                            ],
                            'form_id' => [
                                'type' => 'select',
                                'label' => __('Form', 'fabric'),
                                'options' => $helper->getGravityForms(),
                            ],
                            'show_custom_title' => [
                                'type' => 'select',
                                'label' => __('Display custom title', 'fabric'),
                                'default' => '0',
                                'options' => [
                                    '0' => __('No', 'fabric'),
                                    '1' => __('Yes', 'fabric'),
                                ],
                            ],
                            'show_title' => [
                                'type' => 'select',
                                'label' => __('Display form title', 'fabric'),
                                'default' => '0',
                                'options' => [
                                    '0' => __('No', 'fabric'),
                                    '1' => __('Yes', 'fabric'),
                                ],
                            ],
                            'show_descr' => [
                                'type' => 'select',
                                'label' => __('Display Description', 'fabric'),
                                'default' => '0',
                                'options' => [
                                    '0' => __('No', 'fabric'),
                                    '1' => __('Yes', 'fabric'),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'advanced' => [
                'sections' => [
                    'general' => [
                        'fields' => [
                            'enable_ajax' => [
                                'type' => 'select',
                                'label' => __('Enable Ajax', 'fabric'),
                                'default' => '0',
                                'options' => [
                                    '0' => __('No', 'fabric'),
                                    '1' => __('Yes', 'fabric'),
                                ],
                            ],
                            'disable_scripts' => [
                                'type' => 'select',
                                'label' => __('Disable script output', 'fabric'),
                                'default' => '0',
                                'options' => [
                                    '0' => __('No', 'fabric'),
                                    '1' => __('Yes', 'fabric'),
                                ],
                            ],
                            'tab_index' => [
                                'type' => 'number',
                                'label' => __('Tab index', 'fabric'),
                                'help' => 'If you have other forms on the page (i.e. Comments Form), specify a higher tabindex start value so that your Gravity Form does not end up with the same tabindices as your other forms. To disable the tabindex, enter 0 (zero).',
                                'default' => '1',
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
            'name' => __('Gravity Form', 'fabric'),
            'description' => __('Gravity Form widget', 'fabric'),
            'category' => 'Basic',
            'group' => $helper->getModuleGroup(),
            'dir' => __DIR__,
            'url' => $helper->assetPath(__DIR__),
        ]);
    }
}
