<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\Button;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\AbstractModule;
use function App\sage;

/**
 * Generic Bootstrap button widget
 *
 * @class Button
 */
class Button extends AbstractModule
{
    public static function register(): void
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        FLBuilder::register_module(__CLASS__, [
            'general' => [
                'title' => 'Button',
                'sections' => [
                    'general' => [
                        'fields' => [
                            'text' => [
                                'type' => 'text',
                                'label' => __('Button text', 'fabric'),
                            ],
                            'link' => [
                                'type' => 'link',
                                'label' => __('Button link', 'fabric'),
                            ],
                            'target' => [
                                'type' => 'select',
                                'label' => __('Link target', 'fabric'),
                                'default' => '_self',
                                'options' => $helper->linkTargets(),
                            ],
                            'style' => [
                                'type' => 'select',
                                'label' => __('Button style', 'fabric'),
                                'default' => 'btn-primary',
                                'options' => $helper->buttonStyles(),
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
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        parent::__construct([
            'name' => __('Button', 'fabric'),
            'description' => __('Button widget', 'fabric'),
            'category' => 'Actions',
            'group' => $helper->getModuleGroup(),
            'dir' => __DIR__,
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'button.svg',
        ]);
    }
}
