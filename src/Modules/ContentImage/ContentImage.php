<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\ContentImage;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractBladeModule;
use Itineris\SageFLBuilder\AbstractHelper;
use function App\sage;

/**
 * Generic Bootstrap button widget
 *
 * @class ContentImage
 */
class ContentImage extends AbstractBladeModule
{
    public static function register(): void
    {
        FLBuilder::register_module(__CLASS__, [
            'general' => [
                'title' => 'Image',
                'sections' => [
                    'general' => [
                        'fields' => [
                            'image' => [
                                'type' => 'photo',
                                'label' => __('Image', 'fabric'),
                                'show_remove' => false,
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
            'name' => __('Content image', 'fabric'),
            'description' => __('Content image widget', 'fabric'),
            'category' => 'Media',
            'group' => $helper->getModuleGroup(),
            'dir' => __DIR__,
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'format-image.svg',
        ]);
    }
}
