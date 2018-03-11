<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\Gallery;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractBladeModule;
use Itineris\SageFLBuilder\SageFLBuilder;
use function App\asset_path;

/**
 * Class Gallery
 */
class Gallery extends AbstractBladeModule
{
    public static function register(): void
    {
        FLBuilder::register_module(__CLASS__, [
            'general' => [
                'title' => __('Gallery', 'fabric'),
                'sections' => [
                    'general' => [
                        'fields' => [
                            'show_title' => [
                                'type' => 'select',
                                'label' => __('Show gallery title?', 'fabric'),
                                'options' => [
                                    '0' => __('No', 'fabric'),
                                    '1' => __('Yes', 'fabric'),
                                ],
                            ],
                            'show_summary' => [
                                'type' => 'select',
                                'label' => __('Show gallery summary?', 'fabric'),
                                'options' => [
                                    '0' => __('No', 'fabric'),
                                    '1' => __('Yes', 'fabric'),
                                ],
                            ],
                            'photo_gallery' => [
                                'type' => 'suggest',
                                'label' => __('Gallery', 'fabric'),
                                'action' => 'fl_as_posts',
                                'data' => 'photo_gallery',
                                'limit' => 1,
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
            'name' => __('Gallery', 'fabric'),
            'description' => __('Gallery Widget', 'fabric'),
            'category' => 'Media',
            'group' => SageFLBuilder::MODULE_GROUP,
            'dir' => __DIR__,
            'url' => asset_path(__DIR__),
            'icon' => 'format-gallery.svg',
        ]);
    }

    public function images()
    {
        return get_field('gallery_images', $this->settings->photo_gallery);
    }
}
