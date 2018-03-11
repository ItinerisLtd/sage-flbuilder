<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\PageHeading;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractBladeModule;
use Itineris\SageFLBuilder\AbstractHelper;
use function App\sage;

/**
 * @class PageHeading
 */
class PageHeading extends AbstractBladeModule
{
    public static function register(): void
    {
        FLBuilder::register_module(__CLASS__, [
            'general' => [
                'title' => __('Page Heading', 'fabric'),
                'sections' => [
                    'general' => [
                        'fields' => [
                            'tag' => [
                                'type' => 'select',
                                'label' => __('Heading type', 'fabric'),
                                'default' => 'h1',
                                'options' => [
                                    'h1' => __('Heading 1', 'fabric'),
                                    'h2' => __('Heading 2', 'fabric'),
                                    'h3' => __('Heading 3', 'fabric'),
                                    'h4' => __('Heading 4', 'fabric'),
                                    'h5' => __('Heading 5', 'fabric'),
                                    'h6' => __('Heading 6', 'fabric'),
                                ],
                            ],
                            'title' => [
                                'type' => 'text',
                                'label' => __('Title', 'fabric'),
                                'help' => __('The title of this section', 'fabric'),
                            ],
                            'text' => [
                                'type' => 'textarea',
                                'label' => __('Main text', 'fabric'),
                                'rows' => 5,
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
            'name' => __('Page heading', 'fabric'),
            'description' => __('Page heading module', 'fabric'),
            'category' => 'Basic',
            'group' => $helper->getModuleGroup(),
            'dir' => __DIR__,
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'text.svg',
        ]);
    }
}
