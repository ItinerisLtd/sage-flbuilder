<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\ContentImage;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractModule;
use Itineris\SageFLBuilder\FLBuilderBase;
use function App\asset_path;

/**
 * Generic Bootstrap button widget
 *
 * @class ContentImage
 */
class ContentImage extends AbstractModule
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
        parent::__construct([
            'name' => __('Content image', 'fabric'),
            'description' => __('Content image widget', 'fabric'),
            'category' => 'Media',
            'group' => FLBuilderBase::MODULE_GROUP,
            'dir' => __DIR__,
            'url' => asset_path(__DIR__),
            'icon' => 'format-image.svg',
        ]);
    }
}
