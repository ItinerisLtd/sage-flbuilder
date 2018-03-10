<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\Alert;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractModule;
use Itineris\SageFLBuilder\FLBuilderBase;
use function App\asset_path;

/**
 * Class Alert
 */
class Alert extends AbstractModule
{
    public static function register(): void
    {
        FLBuilder::register_module(__CLASS__, [
            'general' => [
                'title' => __('Alert settings', 'fabric'),
                'sections' => [
                    'general' => [
                        'fields' => [
                            'text' => [
                                'type' => 'editor',
                                'label' => __('Text', 'fabric'),
                                'default' => 'active giving scroller recognition as well.',
                                'media_buttons' => false,
                            ],
                            'style' => [
                                'type' => 'select',
                                'label' => __('Style', 'fabric'),
                                'default' => 'alert-success',
                                'options' => [
                                    'alert-success' => __('Success', 'fabric'),
                                    'alert-info' => __('Info', 'fabric'),
                                    'alert-warning' => __('Warning', 'fabric'),
                                    'alert-danger' => __('Danger', 'fabric'),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct([
            'name' => __('Alert', 'fabric'),
            'description' => __('Alert widget', 'fabric'),
            'category' => 'Actions',
            'group' => FLBuilderBase::MODULE_GROUP,
            'dir' => __DIR__,
            'url' => asset_path(__DIR__),
            'icon' => 'megaphone.svg',
        ]);
    }
}
