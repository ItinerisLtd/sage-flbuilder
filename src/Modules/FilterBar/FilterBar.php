<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\FilterBar;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\AbstractModule;
use function Roots\app;

/**
 * @class FilterBar
 */
class FilterBar extends AbstractModule
{
    public static function register(): void
    {
        FLBuilder::register_module(__CLASS__, [
            'layout' => [
                'title' => __('Layout', 'fabric'),
                'sections' => [
                    'general' => [
                        'fields' => [
                            'data_source' => [
                                'type' => 'select',
                                'label' => __('Data Source', 'fabric'),
                                'options' => [
                                    'main_query' => __('Main query', 'fabric'),
                                    'custom_query' => __('Custom query', 'fabric'),
                                ],
                                'toggle' => [
                                    'main_query' => [],
                                    'custom_query' => [
                                        'fields' => ['post_type'],
                                    ],
                                ],
                            ],
                            'post_type' => [
                                'type' => 'post-type',
                                'label' => __('Post Type', 'fabric'),
                                'help' => __('Choose the content type to relate the filter bar to', 'fabric'),
                                'default' => 'post',
                            ],
                            'auto_filter' => [
                                'type' => 'select',
                                'label' => __('Auto filter?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
                                ],
                            ],
                            'show_button' => [
                                'type' => 'select',
                                'label' => __('Show submit button?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '0' => __('No', 'fabric'),
                                    '1' => __('Yes', 'fabric'),
                                ],
                            ],
                            'show_search_filter' => [
                                'type' => 'select',
                                'label' => __('Show search box?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
                                ],
                            ],
                            'show_meta_filters' => [
                                'type' => 'select',
                                'label' => __('Show field filters?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
                                ],
                            ],
                            'show_cat_desc' => [
                                'type' => 'select',
                                'label' => __('Show category description?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
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
        /** @var AbstractHelper $helper */
        $helper = app(AbstractHelper::class);

        parent::__construct([
            'name' => __('Filter bar', 'fabric'),
            'description' => __('Filter bar widget', 'fabric'),
            'category' => 'Posts',
            'group' => $helper->getModuleGroup(),
            'dir' => __DIR__,
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'layout.svg',
        ]);
    }
}
