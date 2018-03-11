<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\Testimonial;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractBladeModule;
use Itineris\SageFLBuilder\SageFLBuilder;
use function App\asset_path;

/**
 * Generic Testimonial widget
 *
 * @class Testimonial
 */
class Testimonial extends AbstractBladeModule
{
    public static function register(): void
    {
        FLBuilder::register_module(__CLASS__, [
            'general' => [
                'title' => 'Image',
                'sections' => [
                    'general' => [
                        'fields' => [
                            'text' => [
                                'type' => 'textarea',
                                'label' => __('Text', 'fabric'),
                                'rows' => 4,
                            ],
                            'cite_1' => [
                                'type' => 'text',
                                'label' => __('Cite 1', 'fabric'),
                            ],
                            'cite_2' => [
                                'type' => 'text',
                                'label' => __('Cite 2', 'fabric'),
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
            'name' => __('Testimonial', 'fabric'),
            'description' => __('Testimonial widget', 'fabric'),
            'category' => 'Media',
            'group' => SageFLBuilder::MODULE_GROUP,
            'dir' => __DIR__,
            'url' => asset_path(__DIR__),
            'icon' => 'format-quote.svg',
        ]);
    }
}
