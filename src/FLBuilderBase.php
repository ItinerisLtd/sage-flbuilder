<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use FLBuilderModel;
use Itineris\SageFLBuilder\Modules\Accordion\Accordion;
use Itineris\SageFLBuilder\Modules\Alert\Alert;
use Itineris\SageFLBuilder\Modules\Breadcrumbs\Breadcrumbs;
use Itineris\SageFLBuilder\Modules\Button\Button;
use Itineris\SageFLBuilder\Modules\ContentImage\ContentImage;
use Itineris\SageFLBuilder\Modules\FilterBar\FilterBar;
use Itineris\SageFLBuilder\Modules\Gallery\Gallery;
use Itineris\SageFLBuilder\Modules\MainBanner\MainBanner;
use Itineris\SageFLBuilder\Modules\PageHeading\PageHeading;
use Itineris\SageFLBuilder\Modules\PageSlider\PageSlider;
use Itineris\SageFLBuilder\Modules\SecondaryNav\SecondaryNav;
use Itineris\SageFLBuilder\Modules\Table\Table;
use Itineris\SageFLBuilder\Modules\Testimonial\Testimonial;
use Itineris\SageFLBuilder\Modules\Video\Video;
use Itineris\SageFLBuilder\Settings\EventsArchive;
use Itineris\SageFLBuilder\Settings\PostGrid;
use Itineris\SageFLBuilder\Settings\ProductsArchive;
use WP_Query;
use function App\template_path;

/**
 * Beaver Builder extensions
 */
class FLBuilderBase
{
    public const MODULE_CAT = 'Custom Widgets';
    public const MODULE_GROUP = 'Itineris Standard Modules';

    protected const REGISTRABLE_MODULES = [
        Accordion::class,
        Alert::class,
        Breadcrumbs::class,
        Button::class,
        ContentImage::class,
        FilterBar::class,
        Gallery::class,
        MainBanner::class,
        PageHeading::class,
        PageSlider::class,
        SecondaryNav::class,
        Table::class,
        Testimonial::class,
        Video::class,
    ];

    protected const INITIALIZABLE_SETTINGS = [
        EventsArchive::class,
        PostGrid::class,
        ProductsArchive::class,
    ];
    /**
     * Project-specific module class names. Must implements RegistrableModuleInterface.
     *
     * @var string[]
     */
    protected $modules;

    /**
     * Warning: This is a slow database query!
     *
     * @param $postType
     *
     * @return array
     */
    public static function flGetLocations($postType): array
    {
        $locations = [];
        $locQuery = new WP_Query([
            'post_type' => $postType,
            'meta_key' => 'location',
            'meta_query' => [
                [
                    'key' => 'location',
                    'value' => '',
                    'compare' => '!=',
                ],
            ],
        ]);
        if ($locQuery->have_posts()) {
            while ($locQuery->have_posts()) {
                $locQuery->the_post();
                $location = get_field('location', get_the_ID());
                if (! array_key_exists($location, $locations)) {
                    $locations[esc_attr($location)] = $location;
                }
            }
        }
        wp_reset_postdata();

        return $locations;
    }

    public static function flGetFilterCount($settings): int
    {
        $count = 0;
        if (! $settings->show_filter) {
            return $count;
        }
        if ($settings->show_search) {
            $count++;
        }
        if ($settings->show_meta_filters) {
            $count++;
        }

        return $count;
    }

    public static function init(?array $modules = null)
    {
        $builder = new static($modules ?? []);

        $builder->initializeSettings();

        add_action('init', [$builder, 'registerModules'], 99);
        add_action('fl_builder_posts_module_after_pagination', [$builder, 'noPostsFilterBar'], 10, 2);

        add_filter('fl_builder_loop_settings', [$builder, 'forceEventPostType']);
        add_filter('fl_theme_builder_template_include', [$builder, 'loadPageBladeTemplate'], PHP_INT_MAX);
        add_filter('fl_builder_module_frontend_file', [$builder, 'locateTemplate'], 10, 2);
        add_filter('fl_builder_render_module_content', [$builder, 'wrapRichText'], 10, 2);
        add_filter('fl_builder_module_frontend_custom_fab_filter_bar', [$builder, 'filterBarFrontend']);

        return $builder;
    }

    public function initializeSettings(): void
    {
        foreach (self::INITIALIZABLE_SETTINGS as $setting) {
            $setting::init();
        }
    }

    /**
     * FLBuilderBase constructor.
     *
     * @param string[]|null $modules Project-specific module class names. Must implements RegistrableModuleInterface.
     */
    public function __construct(array $modules)
    {
        $this->modules = $modules;
    }

    public function registerModules(): void
    {
        /** @var RegistrableModuleInterface[] $modules */
        $modules = array_merge(self::REGISTRABLE_MODULES, $this->modules);

        foreach ($modules as $module) {
            $module::register();
        }
    }

    public function forceEventPostType($settings)
    {
        if ('fab_events_carousel' === $settings->type) {
            $settings->post_type = 'event';
        }

        return $settings;
    }

    public function loadPageBladeTemplate($template)
    {
        $postType = get_post_type();
        if ('fl-theme-layout' === $postType || is_woocommerce()) {
            $template = template_path(\App\locate_template('woocommerce/fl-builder-woocommerce'));
        } elseif ('fl-theme-layout' === $postType || is_home() || is_archive()) {
            $template = template_path(\App\locate_template('fl-builder-archive'));
        }

        return $template;
    }

    /**
     * Add Laravel Blade support for frontend.php
     *
     * @param $file
     * @param $module
     *
     * @return string
     */
    public function locateTemplate($file, $module): string
    {
        $relativeBbPath = \App\get_relative_bb_path($module, 'frontend', 'module');
        $path = \App\locate_template("../{$relativeBbPath}");

        return $path ? template_path($path) : $file;
    }

    public function wrapRichText($out, $module): string
    {
        if ('rich-text' !== $module->slug) {
            return $out;
        }

        return '<div class="content">' . $out . '</div>';
    }

    public function registerSettingsForm($form, $id)
    {
        if ('post-grid' !== $id) {
            return $form;
        }

        $newOption = [
            'layout' => [
                'sections' => [
                    'general' => [
                        'fields' => [
                            'layout' => [
                                'options' => [
                                    'theme' => __('Theme', 'fl-builder'),
                                ],
                                'toggle' => [
                                    'theme' => [
                                        'fields' => [
                                            'show_filter',
                                            'auto_filter',
                                            'show_search',
                                            'show_meta_filters',
                                            'show_cat_desc',
                                        ],
                                    ],
                                ],
                            ],
                            'show_filter' => [
                                'type' => 'select',
                                'label' => __('Show filter bar?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
                                ],
                                'toggle' => [
                                    '1' => [
                                        'fields' => [
                                            'auto_filter',
                                            'show_button',
                                            'show_search',
                                            'show_meta_filters',
                                            'show_cat_desc',
                                        ],
                                    ],
                                ],
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
                            'show_search' => [
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
        ];

        return array_merge_recursive($form, $newOption);
    }

    public function loadProductMarkupAfterPosts($settings): void
    {
        if ('theme' !== $settings->layout) {
            return;
        }

        $postType = get_post_type() ?: $settings->post_type;
        if ('product' !== $postType) {
            return;
        }

        echo '</ul></div></div>';
    }

    public function filterBarFrontend($settings): string
    {
        $settings['show_filter'] = true;
        $settings['layout'] = 'theme';

        return PostGrid::filterBar((object) $settings);
    }

    public function noPostsFilterBar($settings, $query): void
    {
        if ($query->have_posts()) {
            return;
        }

        $settings->show_filter = true;
        $settings->layout = 'theme';
        echo PostGrid::filterBar($settings);
    }
}
